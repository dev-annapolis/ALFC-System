<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssuredDetail extends Model
{
    protected $fillable = [
        'name',
        'lot_number',
        'street',
        'barangay',
        'city',
        'country',
        'contact_number',
        'email',
        'other_contact_number',
        'facebook_account',
        'viber_account',
        'nature_of_business',
        'other_assets',
        'other_source_of_business',
        'primary_reference',
        'verified_number',
        'verified_mailing_address',
        'customer_care_remarks',
        'additional_reference',


    ];

    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetail::class);
    }

}
