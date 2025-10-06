<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $table = "documents";
    protected $fillable = [
        'lead_id',
        'pan_card',
        'pan_card_status',
        'photograph',
        'photograph_status',
        'adhar_card',
        'adhar_card_status',
        'current_address',
        'current_address_status',
        'permanent_address',
        'permanent_address_status',
        'salary_slip',
        'salary_slip_status',
        'bank_statement',
        'bank_statement_status',
        'cibil',
        'cibil_status',
        'other_documents',
        'other_documents_status',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
