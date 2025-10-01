<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSkillSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('job_skills')->insert([
            ['job_post_id' => 1, 'name' => 'React', 'type' => 'hard', 'is_required' => true, 'created_at' => now(), 'updated_at' => now()],
            ['job_post_id' => 1, 'name' => 'Tailwind CSS', 'type' => 'hard', 'is_required' => true, 'created_at' => now(), 'updated_at' => now()],
            ['job_post_id' => 1, 'name' => 'Teamwork', 'type' => 'soft', 'is_required' => true, 'created_at' => now(), 'updated_at' => now()],
            
            ['job_post_id' => 2, 'name' => 'Accounting', 'type' => 'hard', 'is_required' => true, 'created_at' => now(), 'updated_at' => now()],
            ['job_post_id' => 2, 'name' => 'Attention to Detail', 'type' => 'soft', 'is_required' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
