<?php

namespace App\Models\Grant;

use Illuminate\Database\Eloquent\Model;

class GrantRolePermission extends Model
{
    protected $table = 'grant_role_permissions';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
