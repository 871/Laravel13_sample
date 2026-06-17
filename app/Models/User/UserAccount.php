<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shared\AccountStatusMaster;
use App\Models\User\UserAccountHistory;
use App\Models\User\RefreshToken;
use App\Models\Grant\GrantAccountPermission;
use App\Models\Grant\GrantAccountRole;
use App\Domain\Shared\Enum AS Sen;

class UserAccount extends Model
{
    public $timestamps = false;

    protected $table = 'user_accounts';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'email',
        'password',
        'name',
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
        'created_by' => 'integer',
        'modified_at' => 'datetime',
        'modified_by' => 'integer',
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
        return $this->hasMany(GrantAccountPermission::class, 'account_id')
            ->where('account_type', Sen\AccountType::USER->value);
    }

    public function grantAccountRoles()
    {
        return $this->hasMany(GrantAccountRole::class, 'account_id')
            ->where('account_type', Sen\AccountType::USER->value);
    }
}
