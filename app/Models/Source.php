<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = ['name', 'status'];

    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetail::class);
    }

    public function sourceDivisions()
    {
        return $this->hasMany(SourceDivision::class);
    }

}
