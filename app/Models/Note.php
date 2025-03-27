<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'lead_id',
        'updated_by',
        'note',
        'disposition',
        'lead_assign_by'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function assignBy()
    {
        return $this->belongsTo(User::class, 'lead_assign_by', 'id');
    }
}
