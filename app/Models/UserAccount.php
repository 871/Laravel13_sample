<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;

    protected $table = 'user_accounts';

    protected $fillable = [
        'email', 'password', 'name', 'account_status_master_id',
        'is_email_verified', 'password_changed_at', 'password_expires_at',
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
        return $this->hasMany(UserAccountHistory::class, 'user_account_id');
    }
}
