<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionalManager extends Model
{
    protected $fillable = [
        'user_id', 
        'team_id', 
        'name', 
        'status'
    ];

    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetail::class);
    }
}
