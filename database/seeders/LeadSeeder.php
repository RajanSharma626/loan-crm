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
        $leads = [
            [
                'first_name' => 'Rajan',
                'last_name' => 'Sharma',
                'mobile' => '9876543210',
                'email' => 'rajan.sharma@example.in',
                'lead_source' => 'Google Ads',
                'keyword' => 'Personal Loan',
                'loan_type' => 'Personal Loan',
                'city' => 'Delhi',
                'monthly_salary' => 55000,
                'loan_amount' => 300000,
                'duration' => 60,
                'pancard_number' => 'BPSPS1234A',
                'gender' => 'Male',
                'dob' => '1992-05-14',
                'marital_status' => 'Married',
                'education' => 'MBA',
                'disposition' => 'Open',
                'notes' => 'Prefers weekend calls. Looking for quick disbursal.',
            ],
            [
                'first_name' => 'Neha',
                'last_name' => 'Iyer',
                'mobile' => '9988776655',
                'email' => 'neha.iyer@example.in',
                'lead_source' => 'Referral',
                'keyword' => 'Home Loan',
                'loan_type' => 'Home Loan',
                'city' => 'Bengaluru',
                'monthly_salary' => 78000,
                'loan_amount' => 2500000,
                'duration' => 60,
                'pancard_number' => 'AFOPI5678K',
                'gender' => 'Female',
                'dob' => '1989-11-26',
                'marital_status' => 'Single',
                'education' => 'B.Tech',
                'disposition' => 'Docs received',
                'notes' => 'Shared complete document set, awaiting underwriting.',
            ],
            [
                'first_name' => 'Imran',
                'last_name' => 'Patel',
                'mobile' => '9123456780',
                'email' => 'imran.patel@example.in',
                'lead_source' => 'Facebook',
                'keyword' => 'Business Loan',
                'loan_type' => 'Business Loan',
                'city' => 'Ahmedabad',
                'monthly_salary' => 95000,
                'loan_amount' => 1200000,
                'duration' => 60,
                'pancard_number' => 'CPJPI3456M',
                'gender' => 'Male',
                'dob' => '1985-03-09',
                'marital_status' => 'Married',
                'education' => 'B.Com',
                'disposition' => 'Follow up',
                'notes' => 'Needs follow up for bank statements; prefers morning calls.',
            ],
            [
                'first_name' => 'Sneha',
                'last_name' => 'Kumar',
                'mobile' => '9876543211',
                'email' => 'sneha.kumar@example.in',
                'lead_source' => 'Google Ads',
                'keyword' => 'Personal Loan',
                'loan_type' => 'Personal Loan',
            ],
            [
                'first_name' => 'Rajesh',
                'last_name' => 'Kumar',
                'mobile' => '9876543212',
                'email' => 'rajesh.kumar@example.in',
                'lead_source' => 'Google Ads',
                'keyword' => 'Personal Loan',
                'loan_type' => 'Personal Loan',
                'city' => 'Delhi',
                'monthly_salary' => 55000,
                'loan_amount' => 300000,
                'duration' => 60,
                'pancard_number' => 'BPSPS1234A',
                'gender' => 'Male',
                'dob' => '1992-05-14',
                'marital_status' => 'Married',
                'education' => 'MBA',
                'disposition' => 'Open',
                'notes' => 'Prefers weekend calls. Looking for quick disbursal.',
            ],
            [
                'first_name' => 'Neha',
                'last_name' => 'Iyer',
                'mobile' => '9988776655',
                'email' => 'neha.iyer@example.in',
                'lead_source' => 'Referral',
                'keyword' => 'Home Loan',
                'loan_type' => 'Home Loan',
                'city' => 'Bengaluru',
                'monthly_salary' => 78000,
                'loan_amount' => 2500000,
                'duration' => 60,
                'pancard_number' => 'AFOPI5678K',
                'gender' => 'Female',
                'dob' => '1989-11-26',
                'marital_status' => 'Single',
                'education' => 'B.Tech',
                'disposition' => 'Docs received',
                'notes' => 'Shared complete document set, awaiting underwriting.',
            ],
            [
                'first_name' => 'Imran',
                'last_name' => 'Patel',
                'mobile' => '9123456780',
                'email' => 'imran.patel@example.in',
                'lead_source' => 'Facebook',
                'keyword' => 'Business Loan',
                'loan_type' => 'Business Loan',
            ],
            [
                'first_name' => 'Sneha',
                'last_name' => 'Kumar',
                'mobile' => '9876543211',
                'email' => 'sneha.kumar@example.in',
                'lead_source' => 'Google Ads',
                'keyword' => 'Personal Loan',
                'loan_type' => 'Personal Loan',
            ],
        ];

        foreach ($leads as $lead) {
            Lead::updateOrCreate(
                ['mobile' => $lead['mobile']],
                $lead
            );
        }
    }
}
