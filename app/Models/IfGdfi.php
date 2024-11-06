<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IfGdfi extends Model
{
    protected $fillable = ['name', 'status'];

    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetail::class);
    }

}
