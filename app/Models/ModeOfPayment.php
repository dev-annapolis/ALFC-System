<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeOfPayment extends Model
{
    protected $fillable = ['name', 'status'];

    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetail::class);
    }

    public function paymentChecklists()
    {
        return $this->hasMany(PaymentChecklist::class);
    }
}
