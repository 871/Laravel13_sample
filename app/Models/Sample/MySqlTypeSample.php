<?php

namespace App\Models\Sample;

use Illuminate\Database\Eloquent\Model;

class MySqlTypeSample extends Model
{
    protected $table = 'my_sql_type_samples';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];
}
