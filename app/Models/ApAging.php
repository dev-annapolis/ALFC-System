<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApAging extends Model
{
    //
    protected $fillable = [
        'insurance_detail_id',
        'assured_name',
        'provider_id',
        'remittance_number',
        'policy_number',
        'due_date_start',
        'due_date_end',
        'terms',
        'due_to_provider',
        'total_outstanding',
        'balance',
        'first_payment',
        'second_payment',
        'total_payment',
        'status',
    ];

    public function insuranceDetail()
    {
        return $this->belongsTo(InsuranceDetail::class);
    }
}
