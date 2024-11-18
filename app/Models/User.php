<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username', 
        'password', 
        'name', 
        'email', 
        'viber_number', 
        'role_id', 
        'status', 
        'email_verified_at', 
        'remember_token'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function salesAssociates()
    {
        return $this->hasMany(SalesAssociate::class);
    }

    public function salesManagers()
    {
        return $this->hasMany(SalesManager::class);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
