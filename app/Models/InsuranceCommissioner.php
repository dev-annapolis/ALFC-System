<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceCommissioner extends Model
{
    protected $fillable = [
        'insurance_detail_id',
        'commissioner_id',
        'commissioner_name',
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
