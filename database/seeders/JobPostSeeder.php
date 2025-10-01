<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobPostSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('job_posts')->insert([
            [
                'title' => 'Frontend Developer',
                'slug' => 'frontend-developer',
                'description' => 'Build and maintain user interfaces using React and Tailwind.',
                'responsibilities' => 'Develop reusable components; Collaborate with backend.',
                'benefits' => 'Health insurance, remote work options, paid leave.',
                'employment_type' => 'full_time',
                'work_setup' => 'remote',
                'location' => 'Lusaka',
                'country' => 'Zambia',
                'department' => 'IT',
                'level' => 'mid',
                'salary_range' => 'ZMW 10,000 - 15,000',
                'application_deadline' => now()->addWeeks(3)->toDateString(),
                'status' => 'open',
                'posted_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Accounting Clerk',
                'slug' => 'accounting-clerk',
                'description' => 'Manage daily accounting tasks and support audits.',
                'responsibilities' => 'Maintain ledgers; Process invoices.',
                'benefits' => 'Monthly bonuses, training programs.',
                'employment_type' => 'part_time',
                'work_setup' => 'on_site',
                'location' => 'Ndola',
                'country' => 'Zambia',
                'department' => 'Finance',
                'level' => 'entry',
                'salary_range' => 'ZMW 4,000 - 6,000',
                'application_deadline' => now()->addWeeks(2)->toDateString(),
                'status' => 'open',
                'posted_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
