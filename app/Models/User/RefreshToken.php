<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    protected $table = 'refresh_tokens';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];

    // UUID primary key
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'user_account_id' => 'integer',
        'expires_at' => 'datetime',
    ];

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'user_account_id');
    }
}
