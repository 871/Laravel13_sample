<?php

namespace App\Models\Grant;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grant\GrantRolePermission;
use App\Models\Grant\GrantAccountPermission;

class GrantPermission extends Model
{
    protected $table = 'grant_permissions';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'sort' => 'integer',
        'is_active' => 'boolean',
    ];

    public function rolePermissions()
    {
        return $this->hasMany(GrantRolePermission::class, 'grant_permission_id');
    }

    public function accountPermissions()
    {
        return $this->hasMany(GrantAccountPermission::class, 'grant_permission_id');
    }
}
