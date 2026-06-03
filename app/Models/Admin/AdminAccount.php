<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainAdminAccount;
use App\Models\Shared\AccountStatusMaster;
use App\Models\Admin\AdminAccountHistory;
use App\Models\Grant\GrantAccountPermission;
use App\Models\Grant\GrantAccountRole;
use App\Domain\Shared\Enum AS Sen;

class AdminAccount extends Model
{
    public $timestamps = false;

    protected $table = 'admin_accounts';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'email',
        'password',
        'name',
        'admin_note',
        'account_status_master_id',
        'is_email_verified',
        'password_changed_at',
        'password_expires_at',
        'created_at',
        'created_by',
        'created_ip',
        'modified_at',
        'modified_by',
        'modified_ip',
    ];

    protected $casts = [
        'id' => 'integer',
        'account_status_master_id' => 'integer',
        'is_email_verified' => 'boolean',
        'password_changed_at' => 'datetime',
        'password_expires_at' => 'datetime',
        'created_at' => 'datetime',
        'modified_at' => 'datetime',
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
        return $this->hasMany(GrantAccountPermission::class, 'account_id')
            ->where('account_type', Sen\AccountType::ADMIN->value);
    }

    public function grantAccountRoles()
    {
        return $this->hasMany(GrantAccountRole::class, 'account_id')
            ->where('account_type', Sen\AccountType::ADMIN->value);
    }
}
