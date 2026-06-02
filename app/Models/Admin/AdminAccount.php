<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shared\AccountStatusMaster;
use App\Models\Admin\AdminAccountHistory;
use App\Models\Grant\GrantAccountPermission;
use App\Models\Grant\GrantAccountRole;

class AdminAccount extends Model
{
    protected $table = 'admin_accounts';
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
        return $this->hasMany(AdminAccountHistory::class, 'admin_account_id');
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
