<?php

namespace App\Models\companion;

use Illuminate\Database\Eloquent\Model;

class companionLogModel extends Model
{
    protected $table = 't_companion_log';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'action',
        'created_by',
    ];
    protected $dates = [
        'created_at',
    ];
}
