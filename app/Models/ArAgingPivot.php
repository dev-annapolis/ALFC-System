<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArAgingPivot extends Model
{
    protected $fillable = [
        'ar_aging_id',
        'label',
        'payment_amount',
        'payment_schedule',
        'paid_amount',
        'paid_schedule',
        'over_under_payment',
        'reference_number',
        'ra_remarks',
        'tele_remarks',
        'paid'
    ];

    public function arAging()
    {
        return $this->belongsTo(ArAging::class);
    }
}
