<?php

namespace App\Models\Mail;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $table = 'mails';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];

    public function sentLogs()
    {
        return $this->hasMany(MailSentLog::class, 'mail_id')->orderBy('created', 'desc');
    }

    public function receivedCheckLogs()
    {
        return $this->hasMany(MailReceivedCheckLog::class, 'mail_id')->orderBy('created', 'desc');
    }

    public function bounceLogs()
    {
        return $this->hasMany(MailBounceLog::class, 'mail_id')->orderBy('created', 'desc');
    }
}
