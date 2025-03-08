<?php

namespace App\Models\companion;

use Illuminate\Database\Eloquent\Model;

class companions extends Model
{
    protected $table = 't_companions';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'name',
        'dob',
        'height',
        'sex',
        'category',
        'type',
        'source',
        'purchase_date',
        'purchase_amount',
        'short_description',
        'description',
        'image',
        'micro_chip_number',
        'status',
        'created_by',
        'updated_by',
    ];
    // protected $dates = [
    //     'created_at',
    //     'updated_at',
    // ];
}
