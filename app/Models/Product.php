<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'status'];

    public function subproduct()
    {
        return $this->hasMany(Subproduct::class);
    }

    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetail::class);
    }

}
