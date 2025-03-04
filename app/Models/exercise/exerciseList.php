<?php

namespace App\Models\exercise;

use Illuminate\Database\Eloquent\Model;

class exerciseList extends Model
{
    protected $table = 't_exercise_list';
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
