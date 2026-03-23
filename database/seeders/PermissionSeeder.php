<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'manage students']);
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'view attendance']);
    }
}