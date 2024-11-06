<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'view_name'];

    public function permissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
