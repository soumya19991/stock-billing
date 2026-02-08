<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\user;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        user::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',            
            'password' => bcrypt('admin@123456'),
            'role_id' => 1,
        ]);
       
    }
}