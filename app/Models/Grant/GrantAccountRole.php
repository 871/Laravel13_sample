<?php

namespace App\Models\Grant;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AdminAccount;
use App\Models\User\UserAccount;
use App\Models\Grant\GrantRole;

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

    public function grantRole()
    {
        return $this->belongsTo(GrantRole::class, 'grant_role_id');
    }

    public function adminAccount()
    {
        return $this->belongsTo(AdminAccount::class, 'account_id')->where('account_type', 'ADMIN');
    }

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'account_id')->where('account_type', 'USER');
    }
}
