<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpportunitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('opportunities')->insert([
            [
                'title' => 'Explore opportunities',
                'summary' => 'Explore 12th month present records of a neighborhood.',
                'image' => 'uploads/pics/222.jpg',
                'overlay_intro' => 'Discover what sets our neighborhood apart and how you can grow here.',
                'overlay_details' => 'This extended section reveals further insights, including mentorship programs, scholarship links, and community achievements.'
            ],
            [
                'title' => 'Working at Kumoyo',
                'summary' => 'Explore two most possibilities for the school.',
                'image' => 'uploads/pics/233.jpg',
                'overlay_intro' => 'We value passion, teamwork, and learning.',
                'overlay_details' => 'Here at Kumoyo, employees benefit from flexible schedules, training resources, and international collaboration.'
            ],
            [
                'title' => 'Become a global leader',
                'summary' => 'People can find them in the area too.',
                'image' => 'uploads/pics/219.jpg',
                'overlay_intro' => 'Leadership is not just a position—it’s a mindset.',
                'overlay_details' => 'We nurture talent through international programs, advanced coaching, and global experiences.'
            ]
        ]);
    }
}
