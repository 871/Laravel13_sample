<?php

namespace App\Models\Grant;

use Illuminate\Database\Eloquent\Model;

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
}
