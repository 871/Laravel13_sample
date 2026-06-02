<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_logs';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
