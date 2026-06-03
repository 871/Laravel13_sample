<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AdminAccount;
use App\Models\Shared\AccountStatusMaster;

class AdminAccountHistory extends Model
{
    public $timestamps = false;

    protected $table = 'admin_account_histories';
    protected $guarded = [];


    protected $fillable = [
        'id',
        'admin_account_id',
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
        'operation_type',
        'history_created',
    ];

    protected $casts = [
        'admin_account_id' => 'integer',
        'account_status_master_id' => 'integer',
        'is_email_verified' => 'boolean',
        'password_changed_at' => 'datetime',
        'password_expires_at' => 'datetime',
        'history_created' => 'datetime',
        'created_at' => 'datetime',
        'modified_at' => 'datetime',
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
