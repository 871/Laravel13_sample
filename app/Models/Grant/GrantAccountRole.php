<?php

namespace App\Models\Grant;

use Illuminate\Database\Eloquent\Model;

class GrantAccountRole extends Model
{
    protected $table = 'grant_account_roles';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
