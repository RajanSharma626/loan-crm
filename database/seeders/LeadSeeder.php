<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lead::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'mobile' => '1234567890',
            'email' => 'john.doe@example.com',
            'lead_source' => 'Website',
            'keyword' => 'Loan',
            'loan_type' => 'Personal Loan',
            'city' => 'New York',
            'monthly_salary' => 5000,
            'loan_amount' => 10000,
            'duration' => 365,
            'pancard_number' => 'ABCDE1234F',
            'gender' => 'Male',
            'dob' => '1990-01-01',
            'marital_status' => 'Single',
            'education' => 'Bachelor',
            'disposition' => 'Pending',
            'notes' => 'First lead',
            'agent_id' => 1,
        ]);
    }
}
