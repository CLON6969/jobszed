<?php

namespace App\Mail;

use App\Models\JobApplication;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $emailContent;
    public $interviewDetail;

    public function __construct(JobApplication $application)
    {
        $this->application = $application;

        // ✅ Pull from JobPost
        $this->interviewDetail = $application->jobPost->interviewDetail ?? new \App\Models\InterviewDetail();

        $template = EmailTemplate::where('type', 'interview')->first();
        $this->emailContent = $template ? $template->body : '';

        $this->emailContent = str_replace(
            ['{{name}}','{{job_title}}','{{interview_type}}','{{interview_date}}','{{interview_time}}','{{venue}}','{{requirements}}'],
            [
                $application->user->name,
                $application->jobPost->title,
                $this->interviewDetail->type ?? 'TBD',
                $this->interviewDetail->date ?? 'TBD',
                $this->interviewDetail->time ?? 'TBD',
                $this->interviewDetail->venue ?? 'TBD',
                $this->interviewDetail->requirements ?? 'TBD',
            ],
            $this->emailContent
        );
    }

    public function build()
    {
        return $this->subject('Interview Invitation: ' . $this->application->jobPost->title)
                    ->markdown('emails.interview')
                    ->with([
                        'application'     => $this->application,
                        'emailContent'    => $this->emailContent,
                        'interviewDetail' => $this->interviewDetail,
                    ]);
    }
}
