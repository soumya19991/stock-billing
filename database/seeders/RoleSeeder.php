<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::create(['name' => 'Admin', 'description' => 'this is for admin']);
        Role::create(['name' => 'Staff', 'description' => 'this is for staff']);
    }
}