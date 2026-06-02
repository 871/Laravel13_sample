<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountStatusMaster extends Model
{
    use HasFactory;

    protected $table = 'account_status_masters';

    protected $fillable = [
        'code', 'name', 'description', 'sort', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function adminAccounts()
    {
        return $this->hasMany(AdminAccount::class, 'account_status_master_id');
    }

    public function userAccounts()
    {
        return $this->hasMany(UserAccount::class, 'account_status_master_id');
    }
}
