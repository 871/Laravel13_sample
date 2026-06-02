<?php

namespace App\Models\Grant;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AdminAccount;
use App\Models\User\UserAccount;
use App\Models\Grant\GrantPermission;

class GrantAccountPermission extends Model
{
    protected $table = 'grant_account_permissions';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];

    // UUID primary key
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'grant_permission_id' => 'integer',
        'account_id' => 'integer',
    ];

    public function grantPermission()
    {
        return $this->belongsTo(GrantPermission::class, 'grant_permission_id');
    }

    public function adminAccount()
    {
        return $this->belongsTo(AdminAccount::class, 'account_id')->where('GrantAccountPermissions.account_type', 'ADMIN');
    }

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'account_id')->where('GrantAccountPermissions.account_type', 'USER');
    }
}
