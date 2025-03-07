<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile',
        'email',
        'lead_source',
        'keyword',
        'loan_type',
        'city',
        'monthly_salary',
        'loan_amount',
        'duration',
        'pancard_number',
        'gender',
        'dob',
        'marital_status',
        'education',
        'disposition',
        'notes',
        'agent_name'
    ];
}
