<?php

namespace App\Models\Mail;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $table = 'mails';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
