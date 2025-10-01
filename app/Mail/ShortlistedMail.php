<?php

namespace App\Mail;

use App\Models\JobApplication;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShortlistedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $emailContent;
    public $shortlistedDetail;

    public function __construct(JobApplication $application)
    {
        $this->application = $application;

        // ✅ Pull from JobPost
        $this->shortlistedDetail = $application->jobPost->shortlistedDetail ?? new \App\Models\ShortlistedDetail();

        $template = EmailTemplate::where('type', 'shortlisted')->first();
        $this->emailContent = $template ? $template->body : '';

        $this->emailContent = str_replace(
            ['{{name}}','{{job_title}}','{{notes}}'],
            [
                $application->user->name,
                $application->jobPost->title,
                $this->shortlistedDetail->notes ?? 'You have been shortlisted. Further instructions will follow.'
            ],
            $this->emailContent
        );
    }

    public function build()
    {
        return $this->subject('Shortlisted: ' . $this->application->jobPost->title)
                    ->markdown('emails.shortlisted')
                    ->with([
                        'application'       => $this->application,
                        'emailContent'      => $this->emailContent,
                        'shortlistedDetail' => $this->shortlistedDetail,
                    ]);
    }
}
