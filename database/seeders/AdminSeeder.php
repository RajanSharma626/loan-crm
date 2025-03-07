<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'employee_id' => User::generateEmployeeId(), // Call the function to generate ID
            'position' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // Change this to a secure password
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);
    }
}
