<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceCommisioner extends Model
{
    protected $fillable = ['insurance_detail_id', 'commisioner_id'];

    public function insuranceDetail()
    {
        return $this->belongsTo(InsuranceDetail::class);
    }

    public function commisioner()
    {
        return $this->belongsTo(Commisioner::class);
    }

}
