<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commissioner extends Model
{
    protected $fillable = ['name', 'status'];

    public function insuranceCommissioners()
    {
        return $this->hasMany(InsuranceCommissioner::class);
    }
}
