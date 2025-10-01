<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobExperienceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('job_experiences')->insert([
            [
                'job_post_id' => 1,
                'title' => '2+ years frontend development',
                'description' => 'Experience building SPA with React.js',
                'is_required' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'job_post_id' => 2,
                'title' => '1+ year accounting experience',
                'description' => 'Experience with bookkeeping and audits',
                'is_required' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
