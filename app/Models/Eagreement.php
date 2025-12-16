<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eagreement extends Model
{
    protected $table = 'e_agreement';

    protected $fillable = [
        'lead_id',
        'disposition',
        'applied_amount',
        'approved_amount',
        'duration',
        'interest_rate',
        'processing_fees',
        'repayment_amount',
        'disbursed_amount',
        'application_number',
        'acceptance_token',
        'token_expires_at',
        'signature',
        'acceptance_place',
        'acceptance_ip',
        'acceptance_date',
        'is_accepted',
        'customer_application_status',
        'signed_application',
        'notes',
        'updated_by',
        'closed_date',
        'received_amount'
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
        'acceptance_date' => 'datetime',
        'closed_date' => 'date',
        'is_accepted' => 'boolean',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
