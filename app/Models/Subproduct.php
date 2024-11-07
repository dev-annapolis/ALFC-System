<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subproduct extends Model
{
    protected $fillable = ['product_id', 'name', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function insuranceDetail()
    {
        return $this->hasMany(InsuranceDetail::class);
    }

}
