<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    protected $fillable = [
        'insurance_detail_id',
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
        'provision_receipt',
        'initial_payment',
        'for_billing',
        'over_under_payment',
        'date_of_good_as_sales',
        'payment_status'
    ];

    public function insuranceDetail()
    {
        return $this->belongsTo(InsuranceDetail::class);
    }

}
