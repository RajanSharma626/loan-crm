<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $table = "documents";
    protected $fillable = [
        'lead_id',
        'pan_card',
        'photograph',
        'adhar_card',
        'current_address',
        'permanent_address',
        'salary_slip',
        'bank_statement',
        'cibil',
        'other_documents',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
