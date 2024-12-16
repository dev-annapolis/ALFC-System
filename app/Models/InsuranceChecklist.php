<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceChecklist extends Model
{
    protected $fillable = ['insurance_detail_id', 'payment_checklist_id', 'completed'];

    public function paymentChecklist()
    {
        return $this->belongsTo(PaymentChecklist::class);
    }
}
