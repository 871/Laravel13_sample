<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAccount extends Model
{
    use HasFactory;

    protected $table = 'admin_accounts';

    protected $fillable = [
        'email', 'password', 'name', 'admin_note', 'account_status_master_id',
        'is_email_verified', 'password_changed_at', 'password_expires_at',
        'created_by', 'created_ip', 'modified_by', 'modified_ip',
    ];

    protected $casts = [
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
}
