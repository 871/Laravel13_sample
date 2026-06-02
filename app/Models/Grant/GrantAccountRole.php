<?php

namespace App\Models\Grant;

use Illuminate\Database\Eloquent\Model;

class GrantAccountRole extends Model
{
    protected $table = 'grant_account_roles';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];

    // UUID primary key
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'grant_role_id' => 'integer',
        'account_id' => 'integer',
    ];
}
