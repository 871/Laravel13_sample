<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AdminAccount;
use App\Models\User\UserAccount;

class PageAccessLog extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $table = 'page_access_logs';
    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
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
