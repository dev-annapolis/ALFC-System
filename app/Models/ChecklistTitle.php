<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistTitle extends Model
{
    protected $fillable = ['name', 'status'];

    public function checklistOptions()
    {
        return $this->hasMany(ChecklistOption::class);
    }
}
