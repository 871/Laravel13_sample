<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserAccountHistory extends Model
{
    protected $table = 'user_account_histories';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
