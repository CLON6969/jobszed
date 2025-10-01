<?php

namespace App\Mail;

use App\Models\SupportSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;

class SupportFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public SupportSubmission $submission;

    public function __construct(SupportSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('technical@kumoyotech.com', 'Kumoyo Support'),
            subject: 'Support Submission Form from the Website',
            replyTo: [
                new Address(
                    $this->submission->email,
                    $this->submission->first_name . ' ' . $this->submission->last_name
                )
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.sales_support_form',
            with: ['submission' => $this->submission],
        );
    }
}
