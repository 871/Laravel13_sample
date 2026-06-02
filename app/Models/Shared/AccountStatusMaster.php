<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;

class AccountStatusMaster extends Model
{
    protected $table = 'account_status_masters';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
