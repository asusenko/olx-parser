<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Link;
use Illuminate\Support\Facades\View;
use Resend\Laravel\Facades\Resend;

class CheckLinks extends Command
{
    protected $signature = 'links:check';

    protected $description = 'Check links for price changes and notify all subscribed users.';

    public function handle()
    {
        try {
            $links = Link::with('users')->get();

            foreach ($links as $link) {
                $url = $link->url_link;
                $this->info("Checking link: {$url}");

                $response = Http::get($url);

                if ($response->successful()) {
                    $html = $response->body();

                    preg_match('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', $html, $matches);

                    if (!empty($matches[1])) {
                        $jsonLd = json_decode($matches[1], true);

                        if (isset($jsonLd['offers']['price'])) {
                            $price = $jsonLd['offers']['price'];

                            if (empty($link->last_price)) {
                                $link->last_price = $price;
                                $link->save();
                                $this->info("New price saved for link: {$url}");
                            } elseif ($link->last_price != $price) {
                                $this->warn("Price changed for link: {$url} (Old Price: {$link->last_price}, New Price: {$price})");
                                $oldPrice = $link->last_price;
                                $link->last_price = $price;
                                $link->save();

                                foreach ($link->users as $user) {
                                    $htmlContent = View::make('emails.price-changed', [
                                        'link' => $link,
                                        'oldPrice' => $oldPrice,
                                        'newPrice' => $price,
                                    ])->render();

                                    Resend::emails()->send([
                                        'from' => 'Robot <onboarding@resend.dev>',
                                        'to' => 'susenko.andrii@gmail.com', //$user->email,
                                        'subject' => "Price Changed! ({$user->email})",
                                        'html' => $htmlContent,
                                    ]);

                                    $this->info("Email sent to {$user->email} about price change.");
                                }
                            } else {
                                $this->info("Price remains the same for link: {$url}");
                            }
                        } else {
                            $this->error("Price not found in JSON-LD for link: {$url}");
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
