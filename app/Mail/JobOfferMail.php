<?php

namespace App\Mail;

use App\Models\JobApplication;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobOfferMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $emailContent;
    public $acceptedDetail;

    public function __construct(JobApplication $application)
    {
        $this->application = $application;

        // ✅ Pull AcceptedDetail directly from the related JobPost
        $this->acceptedDetail = $application->jobPost->acceptedDetail ?? new \App\Models\AcceptedDetail();

        // Email template is generic (by type only)
        $template = EmailTemplate::where('type', 'accepted')->first();
        $this->emailContent = $template ? $template->body : '';

        // Replace placeholders with job + acceptedDetail info
        $this->emailContent = str_replace(
            ['{{name}}','{{job_title}}','{{position}}','{{salary}}','{{start_date}}','{{other_terms}}'],
            [
                $application->user->name,
                $application->jobPost->title,
                $this->acceptedDetail->position ?? $application->jobPost->title,
                $this->acceptedDetail->salary ?? 'Negotiable',
                $this->acceptedDetail->start_date ?? 'TBD',
                $this->acceptedDetail->other_terms ?? 'Standard terms apply'
            ],
            $this->emailContent
        );
    }

    public function build()
    {
        return $this->subject('Job Offer: ' . $this->application->jobPost->title)
                    ->markdown('emails.job_offer')
                    ->with([
                        'application' => $this->application,
                        'emailContent' => $this->emailContent,
                        'acceptedDetail' => $this->acceptedDetail
                    ]);
    }
}
