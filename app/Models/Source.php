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

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

}
