<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchManager extends Model
{
    protected $fillable = ['name', 'status'];

    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetail::class);
    }

}
