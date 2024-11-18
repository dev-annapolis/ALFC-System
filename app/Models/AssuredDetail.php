<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssuredDetail extends Model
{
    protected $fillable = [
        'name',
        'address',
        'contact_number',
        'email',
        'other_contact_number',
        'facebook_account',
        'viber_account',
        'nature_of_business',
        'other_assets',
        'other_source_of_business'
    ];

    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetail::class);
    }

}
