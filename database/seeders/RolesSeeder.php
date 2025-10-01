<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'description' => 'System administrator with full access',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'staff',
                'description' => 'Active employee within the organization',
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'name' => 'user',
                'description' => 'Human Resources manager responsible for recruitment and staff',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'applicant',
                'description' => 'Job seeker applying for available positions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
