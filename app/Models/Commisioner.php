<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commisioner extends Model
{
    protected $fillable = ['name', 'status'];

    public function insuranceCommisioners()
    {
        return $this->hasMany(InsuranceCommisioner::class);
    }

}
