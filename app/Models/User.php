<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->employee_id = self::generateEmployeeId();
        });
    }

    public static function generateEmployeeId()
    {
        $latestUser = self::latest('id')->first();

        if (!$latestUser) {
            return 'EMP0001';
        }

        // Extract number from last employee_id and increment
        $lastNumber = (int) substr($latestUser->employee_id, 3);
        return 'EMP' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'name',
        'employee_id',
        'password',
        'position'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
