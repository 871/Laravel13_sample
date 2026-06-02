<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AdminAccount;
use App\Models\Shared\AccountStatusMaster;

class AdminAccountHistory extends Model
{
    protected $table = 'admin_account_histories';
    const CREATED_AT = 'history_created';
    const UPDATED_AT = null;
    public $timestamps = true; // created/modified handled differently; keep true for history_created
    protected $guarded = [];

    protected $casts = [
        'admin_account_id' => 'integer',
        'account_status_master_id' => 'integer',
        'is_email_verified' => 'boolean',
        'password_changed_at' => 'datetime',
        'password_expires_at' => 'datetime',
        'history_created' => 'datetime',
    ];

    public function adminAccount()
    {
        return $this->belongsTo(AdminAccount::class, 'admin_account_id');
    }

    public function accountStatusMaster()
    {
        return $this->belongsTo(AccountStatusMaster::class, 'account_status_master_id');
    }
}
