<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentChecklist extends Model
{
    protected $fillable = ['name', 'status', 'mode_of_payment_id'];

    public function modeOfPayment()
    {
        return $this->belongsTo(ModeOfPayment::class);
    }

    public function insuranceChecklists()
    {
        return $this->hasMany(InsuranceChecklist::class);
    }
}
