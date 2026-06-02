<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminAccountHistory extends Model
{
    protected $table = 'admin_account_histories';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
