<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    protected $fillable = [
        'insurance_detail_id',
        'provision_receipt',
        'provider_id',
        'gross_premium',
        'discount',
        'gross_premium_net_discounted',
        'amount_due_to_provider',
        'full_commission',
        'total_commission',
        'vat',
        'sales_credit',
        'sales_credit_percent',
        'comm_deduct',
        'payment_terms',
        'due_date_start',
        'due_date_end',
        'first_payment_schedule',
        'first_payment_amount',
        'second_payment_schedule',
        'second_payment_amount',
        'third_payment_schedule',
        'third_payment_amount',
        'fourth_payment_schedule',
        'fourth_payment_amount',
        'fifth_payment_schedule',
        'fifth_payment_amount',
        'sixth_payment_schedule',
        'sixth_payment_amount',
        'seventh_payment_schedule',
        'seventh_payment_amount',
        'eight_payment_schedule',
        'eight_payment_amount',
        'for_billing',
        'over_under_payment',
        'initial_payment',
        'date_of_good_as_sales',
        'payment_status',
    ];
    
    public function insuranceDetail()
    {
        return $this->belongsTo(InsuranceDetail::class);
    }
    
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

}
