<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AdminAccount;

class LoginLog extends Model
{
    protected $table = 'login_logs';
    const CREATED_AT = 'logged_in_at';
    const UPDATED_AT = null;
    public $timestamps = true;
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'account_id' => 'integer',
        'impersonator_account_id' => 'integer',
        'logged_in_at' => 'datetime',
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
