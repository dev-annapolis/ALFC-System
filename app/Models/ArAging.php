<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArAging extends Model
{
    protected $fillable = [
        'insurance_detail_id',
        'issuance_code',
        'name',
        'due_date_start',
        'due_date_end',
        'terms',
        'team',
        'policy_number',
        'sale_date',
        'mode_of_payment',
        'gross_premium',
        'total_outstanding',
        'balance',
        'aging_due_days',
        'aging_description',
        'last_paid_date'
    ];

    public function arAgingPivot()
    {
        return $this->hasMany(ArAgingPivot::class);
    }

    public function insuranceDetail()
    {
        return $this->belongsTo(InsuranceDetail::class);
    }
    public function arAgingPivots()
    {
        return $this->hasMany(ArAgingPivot::class, 'ar_aging_id');
    }
}
