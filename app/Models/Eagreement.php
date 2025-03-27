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
        'customer_application_status',
        'signed_application',
        'notes',
        'updated_by'
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
