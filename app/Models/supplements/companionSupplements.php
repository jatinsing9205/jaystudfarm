<?php

namespace App\Models\supplements;

use Illuminate\Database\Eloquent\Model;

class companionSupplements extends Model
{
    protected $table = 't_companion_supplements';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'date',
        'supplement',
        'quantity',
        'unit',
        'time',
        'expected_date',
        'expected_status',
        'administered_by',
        'remark',
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
