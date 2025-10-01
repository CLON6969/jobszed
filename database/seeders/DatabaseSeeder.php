<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user(s)
User::updateOrCreate(
    ['email' => 'test@example.com'],
    ['name' => 'Test User']
);

        // Call your custom job seeders here:
        $this->call([
            JobPostSeeder::class,
            JobSkillSeeder::class,
            JobExperienceSeeder::class,
            JobQualificationSeeder::class,
            OpportunitySeeder::class,
            RolesSeeder::class,
        ]);
    }
}
