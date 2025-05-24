<?php

namespace App\Models\grooming;

use Illuminate\Database\Eloquent\Model;

class companionGrooming extends Model
{
    protected $table = 't_companion_grooming';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'date',
        'morning_grooming',
        'evening_grooming',
        'administered_by',
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
