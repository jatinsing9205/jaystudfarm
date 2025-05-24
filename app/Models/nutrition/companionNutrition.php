<?php

namespace App\Models\nutrition;

use Illuminate\Database\Eloquent\Model;

class companionNutrition extends Model
{
    protected $table = 't_companion_nutrition';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'companion_id',
        'food',
        'quantity',
        'unit',
        'first_feed_timing',
        'second_feed_timing',
        'expected_date',
        'expected_status',
        'administered_by',
        'remark',
        'created_by',
        'updated_by ',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
