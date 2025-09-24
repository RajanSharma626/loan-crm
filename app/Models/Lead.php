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

    public function notesRelation()
    {
        return $this->hasMany(Note::class, 'lead_id', 'id');
    }

    public function eagreement()
    {
        return $this->hasOne(Eagreement::class, 'lead_id', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }

    public function document()
    {
        return $this->hasOne(Documents::class, 'lead_id', 'id');
    }
}
