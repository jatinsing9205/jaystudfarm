<?php

namespace App\Models\supplements;

use Illuminate\Database\Eloquent\Model;

class supplementList extends Model
{
    protected $table = 't_supplement_list';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
