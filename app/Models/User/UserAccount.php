<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shared\AccountStatusMaster;
use App\Models\User\UserAccountHistory;
use App\Models\User\RefreshToken;
use App\Models\Grant\GrantAccountPermission;
use App\Models\Grant\GrantAccountRole;

class UserAccount extends Model
{
    protected $table = 'user_accounts';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'account_status_master_id' => 'integer',
        'is_email_verified' => 'boolean',
        'password_changed_at' => 'datetime',
        'password_expires_at' => 'datetime',
    ];

    public function accountStatusMaster()
    {
        return $this->belongsTo(AccountStatusMaster::class, 'account_status_master_id');
    }

    public function histories()
    {
        return $this->hasMany(UserAccountHistory::class, 'user_account_id');
    }

    public function refreshTokens()
    {
        return $this->hasMany(RefreshToken::class, 'user_account_id');
    }

    public function grantAccountPermissions()
    {
        return $this->hasMany(GrantAccountPermission::class, 'account_id');
    }

    public function grantAccountRoles()
    {
        return $this->hasMany(GrantAccountRole::class, 'account_id');
    }
}
