<?php

namespace App\Models\Grant;

use Illuminate\Database\Eloquent\Model;

class GrantRole extends Model
{
    protected $table = 'grant_roles';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
