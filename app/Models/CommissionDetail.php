<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionDetail extends Model
{
    protected $fillable = [
        'insurance_detail_id', 'provision_receipt', 'gross_premium', 'discount',
        'net_discounted', 'amount_due_to_provider', 'full_commission', 'marketing_fund', 
        'offsetting', 'promo', 'total_commission', 'vat', 'sales_credit', 
        'sales_credit_percent', 'comm_deduct'
    ];
    
    public function insuranceDetail()
    {
        return $this->belongsTo(InsuranceDetail::class);
    }
}
