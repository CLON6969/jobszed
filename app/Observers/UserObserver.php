<?php

namespace App\Observers;

use App\Models\User;
use App\Models\EmailTemplate;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user)
    {
        // Only run for employers (role_id = 3)
        if ($user->role_id == 3) {
            $this->createEmailTemplates($user);
        }
    }

    /**
     * Create default email templates for the employer.
     */
    protected function createEmailTemplates(User $user)
    {
        $templates = [
            [
                'type' => 'interview',
                'subject' => 'Interview Invitation - {{job_title}}',
                'body' => "Dear {{name}},<br><br>
                    We are pleased to invite you for an interview.<br><br>
                    <strong>Type:</strong> {{interview_type}}<br>
                    <strong>Date:</strong> {{interview_date}}<br>
                    <strong>Time:</strong> {{interview_time}}<br>
                    <strong>Venue:</strong> {{venue}}<br><br>
                    Please bring: {{requirements}}<br><br>
                    Regards,<br>HR Team",
            ],
            [
                'type' => 'accepted',
                'subject' => 'Job Offer - {{job_title}}',
                'body' => "Dear {{name}},<br><br>
                    Congratulations! You have been accepted for {{job_title}}.<br><br>
                    <strong>Start Date:</strong> {{start_date}}<br>
                    <strong>Position:</strong> {{position}}<br>
                    <strong>Salary:</strong> {{salary}}<br>
                    {{other_terms}}<br><br>
                    Regards,<br>HR Team",
            ],
            [
                'type' => 'shortlisted',
                'subject' => 'You are Shortlisted - {{job_title}}',
                'body' => "Dear {{name}},<br><br>
                    You have been shortlisted for {{job_title}}.<br>
                    Notes: {{notes}}<br><br>
                    Regards,<br>HR Team",
            ],
            [
                'type' => 'rejected',
                'subject' => 'Application Update - {{job_title}}',
                'body' => "Dear {{name}},<br><br>
                    Unfortunately, your application for {{job_title}} was not successful.<br>
                    Reason: {{reason}}<br><br>
                    Regards,<br>HR Team",
            ],
        ];

        foreach ($templates as $tpl) {
            EmailTemplate::create([
                'user_id' => $user->id,
                'type'    => $tpl['type'],
                'subject' => $tpl['subject'],
                'body'    => $tpl['body'],
            ]);
        }
    }
}
