<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourceDivision extends Model
{
    protected $fillable = ['source_id', 'name', 'status'];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
    
    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetail::class);
    }
}
