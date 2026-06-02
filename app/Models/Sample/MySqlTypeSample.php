<?php

namespace App\Models\Sample;

use Illuminate\Database\Eloquent\Model;

class MySqlTypeSample extends Model
{
    protected $table = 'my_sql_type_samples';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $guarded = [];

    protected $casts = [
        'int_col' => 'integer',
        'bigint_col' => 'integer',
        'decimal_col' => 'decimal:6',
        'float_col' => 'float',
        'double_col' => 'float',
        'date_col' => 'date',
        'time_col' => 'string',
        'datetime_col' => 'datetime',
        'json_col' => 'array',
    ];
}
