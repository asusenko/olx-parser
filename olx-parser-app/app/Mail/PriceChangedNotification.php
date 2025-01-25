<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PriceChangedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $oldPrice;
    public $newPrice;

    /**
     * Create a new message instance.
     *
     * @param $link
     * @param $oldPrice
     * @param $newPrice
     */
    public function __construct($link, $oldPrice, $newPrice)
    {
        $this->link = $link;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Price Changed Notification')
                    ->view('emails.price-changed'); // Reference the Blade template
    }
}
