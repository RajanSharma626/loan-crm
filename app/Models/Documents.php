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
        'pan_card_remarks',
        'photograph',
        'photograph_status',
        'photograph_remarks',
        'adhar_card',
        'adhar_card_status',
        'adhar_card_remarks',
        'current_address',
        'current_address_status',
        'current_address_remarks',
        'permanent_address',
        'permanent_address_status',
        'permanent_address_remarks',
        'salary_slip',
        'salary_slip_status',
        'salary_slip_remarks',
        'bank_statement',
        'bank_statement_status',
        'bank_statement_remarks',
        'cibil',
        'cibil_status',
        'cibil_remarks',
        'other_documents',
        'other_documents_status',
        'other_documents_remarks',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
