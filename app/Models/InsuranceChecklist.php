<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceChecklist extends Model
{
    protected $fillable = ['insurance_detail_id', 'checklist_option_id', 'completed'];

    public function checklistOption()
    {
        return $this->belongsTo(ChecklistOption::class);
    }
}
