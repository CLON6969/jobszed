<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EmailTemplate;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $defaultTemplates = [
            [
                'type' => 'interview',
                'subject' => 'Interview Invitation - {{job_title}}',
                'body' => 'Dear {{name}},<br><br>We are pleased to invite you for an interview.<br><br>
                           <strong>Type:</strong> {{interview_type}}<br>
                           <strong>Date:</strong> {{interview_date}}<br>
                           <strong>Time:</strong> {{interview_time}}<br>
                           <strong>Venue:</strong> {{venue}}<br><br>
                           Please bring: {{requirements}}<br><br>
                           Regards,<br>HR Team',
            ],
            [
                'type' => 'accepted',
                'subject' => 'Job Offer - {{job_title}}',
                'body' => 'Dear {{name}},<br><br>Congratulations! You have been accepted for {{job_title}}.<br><br>
                           <strong>Start Date:</strong> {{start_date}}<br>
                           <strong>Position:</strong> {{position}}<br>
                           <strong>Salary:</strong> {{salary}}<br>
                           {{other_terms}}<br><br>
                           Regards,<br>HR Team',
            ],
            [
                'type' => 'shortlisted',
                'subject' => 'You are Shortlisted - {{job_title}}',
                'body' => 'Dear {{name}},<br><br>You have been shortlisted for {{job_title}}.<br>
                           Notes: {{notes}}<br><br>
                           Regards,<br>HR Team',
            ],
            [
                'type' => 'rejected',
                'subject' => 'Application Update - {{job_title}}',
                'body' => 'Dear {{name}},<br><br>Unfortunately, your application for {{job_title}} was not successful.<br>
                           Reason: {{reason}}<br><br>
                           Regards,<br>HR Team',
            ],
        ];

        // Get all employers (role_id = 3)
        $employers = User::where('role_id', 3)->get();

        foreach ($employers as $employer) {
            foreach ($defaultTemplates as $template) {
                EmailTemplate::firstOrCreate(
                    [
                        'user_id' => $employer->id,
                        'type'    => $template['type'],
                    ],
                    [
                        'subject' => $template['subject'],
                        'body'    => $template['body'],
                    ]
                );
            }
        }
    }
}
