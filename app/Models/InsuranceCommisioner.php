<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceCommisioner extends Model
{
    protected $fillable = [
        'insurance_detail_id', 
        'commisioner_id', 
        'commisioner_name', 
        'amount'
    ];

    public function insuranceDetail()
    {
        return $this->belongsTo(InsuranceDetail::class);
    }

    public function commissioner()
    {
        return $this->belongsTo(Commissioner::class);
    }

}
