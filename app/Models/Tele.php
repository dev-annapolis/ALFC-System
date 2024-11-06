<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tele extends Model
{
    protected $fillable = ['name', 'status'];

    public function collectionDetails()
    {
        return $this->hasMany(CollectionDetail::class);
    }

}
