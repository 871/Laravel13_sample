<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AdminAccount;
use App\Models\User\UserAccount;

class PageAccessLog extends Model
{
    protected $table = 'page_access_logs';
    const CREATED_AT = 'accessed';
    const UPDATED_AT = null;
    public $timestamps = true;
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'account_id' => 'integer',
        'accessed' => 'datetime',
    ];

    public function adminAccount()
    {
        return $this->belongsTo(AdminAccount::class, 'account_id')->where('account_type', 'ADMIN');
    }

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'account_id')->where('account_type', 'USER');
    }
}
