<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = ['role_id', 'table_name', 'column_name', 'can_view', 'can_edit'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
