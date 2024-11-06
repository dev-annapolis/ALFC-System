<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssuredDetail extends Model
{
    protected $fillable = ['address', 'contact_number', 'other_contact_number', 'facebook_account', 'viber_account', 'nature_of_business', 'other_assets', 'remarks'];

    public function assured()
    {
        return $this->hasOne(Assured::class);
    }

}
