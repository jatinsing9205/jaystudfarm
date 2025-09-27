<?php

namespace App\Models\pregnancy;

use Illuminate\Database\Eloquent\Model;

class companionPregnancy extends Model
{
    protected $table = 't_companion_pregnancy';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'date',
        'heat',
        'miss_heat',
        'mating',
        'mating_date',
        'companion_used',
        'expected_date',
        'remark',
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
