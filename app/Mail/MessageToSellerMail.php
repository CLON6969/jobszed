<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageToSellerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $messageContent;
    public $guest_name;
    public $guest_email;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->product = $data['product'];
        $this->messageContent = $data['message'];
        $this->guest_name = $data['guest_name'] ?? null;
        $this->guest_email = $data['guest_email'] ?? null;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Product Inquiry: ' . $this->product->name)
                    ->view('emails.message_to_seller')
                    ->with([
                        'product' => $this->product,
                        'messageContent' => $this->messageContent,
                        'guest_name' => $this->guest_name,
                        'guest_email' => $this->guest_email,
                    ]);
    }
}
