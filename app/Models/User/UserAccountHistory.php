<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\UserAccount;
use App\Models\Shared\AccountStatusMaster;

class UserAccountHistory extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $table = 'user_account_histories';
    protected $guarded = [];

    protected $casts = [
        'user_account_id' => 'integer',
        'account_status_master_id' => 'integer',
        'is_email_verified' => 'boolean',
        'password_changed_at' => 'datetime',
        'password_expires_at' => 'datetime',
        'history_created' => 'datetime',
        'created_at' => 'datetime',
        'created_by' => 'integer',
        'modified_at' => 'datetime',
        'modified_by' => 'integer',
    ];

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'user_account_id');
    }

    public function accountStatusMaster()
    {
        return $this->belongsTo(AccountStatusMaster::class, 'account_status_master_id');
    }
}
