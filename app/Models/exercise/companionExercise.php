<?php

namespace App\Models\exercise;

use Illuminate\Database\Eloquent\Model;

class companionExercise extends Model
{
    protected $table = 't_companion_exercise';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'exercise',
        'date',
        'given_by',
        'monitored_by',
        'time_spent',
        'expected_date',
        'expected_status',
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
