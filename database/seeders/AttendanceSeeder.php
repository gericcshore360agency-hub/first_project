<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('attendances')->insert([
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'date' => '2026-03-18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'date' => '2026-03-18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Mark',
                'last_name' => 'Lee',
                'date' => '2026-03-19',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}