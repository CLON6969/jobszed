<?php
namespace App\Mail;

use App\Models\JobApplication;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $emailContent;
    public $rejectedDetail;

    public function __construct(JobApplication $application)
    {
        $this->application = $application;

        // ✅ Pull from JobPost
        $this->rejectedDetail = $application->jobPost->rejectedDetail ?? new \App\Models\RejectedDetail();

        $template = EmailTemplate::where('type', 'rejected')->first();
        $this->emailContent = $template ? $template->body : '';

        $this->emailContent = str_replace(
            ['{{name}}','{{job_title}}','{{reason}}'],
            [
                $application->user->name,
                $application->jobPost->title,
                $this->rejectedDetail->reason ?? 'Not specified'
            ],
            $this->emailContent
        );
    }

    public function build()
    {
        return $this->subject('Application Update: ' . $this->application->jobPost->title)
                    ->markdown('emails.rejected')
                    ->with([
                        'application'    => $this->application,
                        'emailContent'   => $this->emailContent,
                        'rejectedDetail' => $this->rejectedDetail,
                    ]);
    }
}
