<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionDetail extends Model
{
    protected $fillable = [
        'insurance_detail_id',
        'gross_premium',
        'discount',
        'gross_premium_net_discounted',
        'amount_due_to_provider',
        'full_commission',
        // 'travel_incentives',
        // 'offsetting',
        // 'promo',
        'vat',
        'sales_credit',
        'sales_credit_percent',
        'comm_deduct',
        'total_commission'
    ];

    public function insuranceDetail()
    {
        return $this->belongsTo(InsuranceDetail::class);
    }
}
