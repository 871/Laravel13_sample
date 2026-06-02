<?php

namespace App\Models\Mail;

use Illuminate\Database\Eloquent\Model;

class MailReceivedCheckLog extends Model
{
    protected $table = 'mail_received_check_logs';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];

    public function mail()
    {
        return $this->belongsTo(Mail::class, 'mail_id');
    }
}
