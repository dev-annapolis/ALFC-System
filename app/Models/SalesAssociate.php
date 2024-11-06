<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesAssociate extends Model
{
    protected $fillable = ['user_id', 'team_id', 'name', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetail::class);
    }

}
