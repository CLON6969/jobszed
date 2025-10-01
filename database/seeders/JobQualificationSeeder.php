<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobQualificationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('job_qualifications')->insert([
            [
                'job_post_id' => 1,
                'title' => 'Bachelor’s Degree in Computer Science',
                'level' => 'bachelor',
                'is_required' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'job_post_id' => 2,
                'title' => 'Diploma in Accounting',
                'level' => 'diploma',
                'is_required' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
