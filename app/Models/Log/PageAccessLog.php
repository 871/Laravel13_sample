<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

class PageAccessLog extends Model
{
    protected $table = 'page_access_logs';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
