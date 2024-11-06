<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assured extends Model
{
    protected $fillable = ['name', 'assured_detail_id'];

    public function assuredDetail()
    {
        return $this->belongsTo(AssuredDetail::class);
    }

    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetail::class);
    }

}
