<?php

namespace App\Models\Grant;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grant\GrantAccountRole;
use App\Models\Grant\GrantRolePermission;

class GrantRole extends Model
{
    protected $table = 'grant_roles';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'sort' => 'integer',
        'is_active' => 'boolean',
    ];

    public function accountRoles()
    {
        return $this->hasMany(GrantAccountRole::class, 'grant_role_id');
    }

    public function rolePermissions()
    {
        return $this->hasMany(GrantRolePermission::class, 'grant_role_id');
    }
}
