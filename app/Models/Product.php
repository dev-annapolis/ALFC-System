<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'status'];

    public function subproducts()
    {
        return $this->hasMany(Subproduct::class);
    }

}
