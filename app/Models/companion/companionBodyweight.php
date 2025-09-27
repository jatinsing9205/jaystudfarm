<?php

namespace App\Models\companion;

use Illuminate\Database\Eloquent\Model;

class companionBodyweight extends Model
{
    protected $table = 't_companion_body_weight';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'date',
        'body_weight',
        'checked_by',
        'expected_date',
        'expected_status',
        'remark',
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
