<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionDetail extends Model
{
    protected $fillable = [
        'insurance_detail_id', 'insurance_type', 'sale_status', 'tele_id', 'due_date', 
        'paid_terms', 'payment_remarks', 'account_status', 'payment_ptp_declared', 
        'payment_center', 'reference_number', 'date_on_receipt_abstract', 
        'contact_number_verification'
    ];
    
    public function insuranceDetail()
    {
        return $this->belongsTo(InsuranceDetail::class);
    }
    
    public function tele()
    {
        return $this->belongsTo(Tele::class);
    }
    
}
