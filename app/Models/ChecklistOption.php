<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistOption extends Model
{
    protected $fillable = ['name', 'status', 'checklist_title_id'];

    public function checklistTitle()
    {
        return $this->belongsTo(Team::class);
    }
}
