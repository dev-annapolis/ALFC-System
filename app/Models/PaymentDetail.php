<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    protected $fillable = [
        'insurance_detail_id', 'payment_terms', 'due_date', 'schedule_first_payment',
        'schedule_second_payment', 'schedule_third_payment', 'schedule_fourth_payment', 
        'schedule_fifth_payment', 'schedule_sixth_payment', 'schedule_seventh_payment', 
        'schedule_eight_payment', 'for_billing', 'over_under_payment', 'initial_payment', 
        'good_as_sales_date', 'status', 'ra_comments', 'admin_assistant_remarks', 
        'tracking_number', 'policy_received_by'
    ];
    
    public function insuranceDetail()
    {
        return $this->belongsTo(InsuranceDetail::class);
    }
    
}
