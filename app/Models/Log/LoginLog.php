<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AdminAccount;

class LoginLog extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $table = 'login_logs';
    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
        'account_id' => 'integer',
        'impersonator_account_id' => 'integer',
        'logged_in_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function adminAccount()
    {
        return $this->belongsTo(AdminAccount::class, 'account_id')->where('login_actor_type', 'ADMIN');
    }

    public function impersonatorAdminAccount()
    {
        return $this->belongsTo(AdminAccount::class, 'impersonator_account_id');
    }
}
