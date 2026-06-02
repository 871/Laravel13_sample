<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MySqlTypeSample extends Model
{
    use HasFactory;

    protected $table = 'my_sql_type_samples';

    protected $fillable = [
        'int_col','bigint_col','decimal_col','float_col','double_col','date_col',
        'time_col','datetime_col','char_col','varchar_col','text_col','mediumtext_col',
        'longtext_col','json_col','search_text',
    ];

    protected $casts = [
        'json_col' => 'array',
        'date_col' => 'date',
        'time_col' => 'string',
        'datetime_col' => 'datetime',
    ];
}
