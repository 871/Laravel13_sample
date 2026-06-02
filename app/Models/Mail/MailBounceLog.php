<?php

namespace App\Models\Mail;

use Illuminate\Database\Eloquent\Model;

class MailBounceLog extends Model
{
    protected $table = 'mail_bounce_logs';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
