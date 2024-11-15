<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'status'];

    public function salesAssociates()
    {
        return $this->hasMany(SalesAssociate::class);
    }

    public function salesManagers()
    {
        return $this->hasMany(SalesManager::class);
    }

}
