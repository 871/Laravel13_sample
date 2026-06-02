<?php

namespace App\Models\Grant;

use Illuminate\Database\Eloquent\Model;

class GrantAccountPermission extends Model
{
    protected $table = 'grant_account_permissions';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
