<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Link;
use Resend\Laravel\Facades\Resend;
use Illuminate\Support\Facades\View;

class CheckLinks extends Command
{
    protected $signature = 'links:check';

    protected $description = 'Check links for price changes and notify all subscribed users.';

    public function handle()
    {
        try {
            // Отримуємо всі унікальні посилання
            $linksGrouped = Link::all()->groupBy('url_link');

            foreach ($linksGrouped as $url => $links) {
                $this->info("Checking link: {$url}");

                // Перевіряємо ціну лише один раз для унікального посилання
                $response = Http::get($url);

                if ($response->successful()) {
                    $html = $response->body();

                    // Витягуємо JSON-LD блок з HTML
                    preg_match('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', $html, $matches);

                    if (!empty($matches[1])) {
                        $jsonLd = json_decode($matches[1], true);

                        if (isset($jsonLd['offers']['price'])) {
                            $price = $jsonLd['offers']['price'];
                            $firstLink = $links->first(); // Беремо перший запис для оновлення ціни

                            // Обробка зміни ціни
                            if (empty($firstLink->last_price)) {
                                $firstLink->last_price = $price;
                                $firstLink->save();
                                $this->info("New price saved for link: {$url}");
                            } elseif ($firstLink->last_price != $price) {
                                $this->warn("Price changed for link: {$url} (Old Price: {$firstLink->last_price}, New Price: {$price})");
                                $firstLink->last_price = $price;
                                $firstLink->save();

                                // Повідомляємо всіх підписників
                                foreach ($links as $link) {
                                    if ($link->user) {
                                        $htmlContent = View::make('emails.price-changed', [
                                            'link' => $link,
                                            'oldPrice' => $firstLink->last_price,
                                            'newPrice' => $price,
                                        ])->render();

                                        Resend::emails()->send([
                                            'from' => 'Robot <onboarding@resend.dev>',
                                            'to' => $link->user->email,
                                            'subject' => 'Price Changed!',
                                            'html' => $htmlContent,
                                        ]);

                                        $this->info("Email sent to {$link->user->email} about price change.");
                                    }
                                }
                            } else {
                                $this->info("Price remains the same for link: {$url}");
                            }
                        } else {
                            $this->error("Price not found for link: {$url}");
                        }
                    } else {
                        $this->error("JSON-LD block not found for link: {$url}");
                    }
                } else {
                    $this->error("Failed to fetch link: {$url} (HTTP {$response->status()})");
                }
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
