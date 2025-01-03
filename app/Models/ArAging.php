<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArAging extends Model
{
    protected $fillable = [
        'insurance_detail_id',
        'issuance_code',
        'name',
        'due_date',
        'terms',
        'team',
        'policy_number',
        'sale_date',
        'mode_of_payment',
        'gross_premium',
        'total_outstanding',
        'balance'
    ];
    
    public function arAgingPivot()
    {
        return $this->hasMany(ArAgingPivot::class);
    }

    public function insuranceDetail()
    {
        return $this->belongsTo(InsuranceDetail::class);
    }
}
