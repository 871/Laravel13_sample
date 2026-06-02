<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminAccount extends Model
{
    protected $table = 'admin_accounts';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
