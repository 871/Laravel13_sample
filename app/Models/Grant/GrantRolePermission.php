<?php

namespace App\Models\Grant;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grant\GrantRole;
use App\Models\Grant\GrantPermission;

class GrantRolePermission extends Model
{
    protected $table = 'grant_role_permissions';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];

    // UUID primary key
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'grant_role_id' => 'integer',
        'grant_permission_id' => 'integer',
    ];

    public function grantRole()
    {
        return $this->belongsTo(GrantRole::class, 'grant_role_id')->whereColumn('grant_roles.account_type', 'grant_role_permissions.account_type');
    }

    public function grantPermission()
    {
        return $this->belongsTo(GrantPermission::class, 'grant_permission_id')->whereColumn('grant_permissions.account_type', 'grant_role_permissions.account_type');
    }
}
