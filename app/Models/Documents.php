<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $table = "documents";
    protected $fillable = [
        'lead_id',
        'pan_card',
        'photo_1',
        'photo_2',
        'photo_3',
        'id_proof',
        'updated_by',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
