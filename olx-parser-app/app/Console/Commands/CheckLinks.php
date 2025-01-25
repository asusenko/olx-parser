<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Link; // Replace with the correct namespace for your Link model
use Resend\Laravel\Facades\Resend;
use Illuminate\Support\Facades\View;

class CheckLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check links for price changes and output the price to the console.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // Retrieve all links from the database
            $links = Link::all();

            foreach ($links as $link) {
                $this->info("Checking link: {$link->url_link}");

                // Fetch the HTML content of the link
                $response = Http::get($link->url_link);

                if ($response->successful()) {
                    $html = $response->body();

                    // Extract the JSON-LD block
                    preg_match('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', $html, $matches);

                    if (!empty($matches[1])) {
                        $jsonLd = json_decode($matches[1], true);

                        if (isset($jsonLd['offers']['price'])) {
                            $price = $jsonLd['offers']['price'];
                        
                            // Handle last_price logic
                            if (empty($link->last_price)) {
                                // Save the price if no previous price exists
                                $link->last_price = $price;
                                $link->save();
                                $this->info("New price saved for link {$link->url_link}: {$price} UAH");
                            } elseif ($link->last_price == $price) {
                                // Do nothing if the price hasn't changed
                                $this->info("Price for link {$link->url_link} remains the same: {$price} UAH");
                            } else {
                                // Handle price change
                                //$this->warn("Price was changed for link {$link->url_link}: Old Price: {$link->last_price} UAH, New Price: {$price} UAH");
                                
                                $this->info("New price saved for link {$link->url_link}");
                                $userEmail = $link->user->email;

                                $this->info("Email of the user {$userEmail}");

                                $htmlContent = View::make('emails.price-changed', [
                                    'link' => $link,
                                    'oldPrice' => $link->last_price,
                                    'newPrice' => $price,
                                ])->render();

                                // Send an email notification
                                Resend::emails()->send([
                                    'from' => 'Robot <onboarding@resend.dev>',
                                    'to' => $userEmail,
                                    'subject' => 'Price changed!',
                                  //  'html' => 'The price for link ' . $link->url_link . ' has changed. Old Price: ' . $link->last_price . ' UAH, New Price: ' . $price . ' UAH',    
                                
                                    'html' => $htmlContent,]);
                                $link->last_price = $price;
                                $link->save();

                            }
                        } else {
                            $this->error("Price not found in JSON-LD for link: {$link->url_link}");
                        }
                        
                    } else {
                        $this->error("JSON-LD block not found for link: {$link->url_link}");
                    }
                } else {
                    $this->error("Failed to fetch link: {$link->url_link} (HTTP {$response->status()})");
                }
            }

        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
