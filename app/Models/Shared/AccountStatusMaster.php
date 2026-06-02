<?php

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AdminAccount;
use App\Models\Admin\AdminAccountHistory;

class AccountStatusMaster extends Model
{
    protected $table = 'account_status_masters';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'sort' => 'integer',
        'is_active' => 'boolean',
    ];

    public function adminAccounts()
    {
        return $this->hasMany(AdminAccount::class, 'account_status_master_id');
    }

    public function adminAccountHistories()
    {
        return $this->hasMany(AdminAccountHistory::class, 'account_status_master_id');
    }
}
