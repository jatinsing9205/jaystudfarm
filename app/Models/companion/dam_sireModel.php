<?php

namespace App\Models\companion;

use Illuminate\Database\Eloquent\Model;

class dam_sireModel extends Model
{
    protected $table = 't_companion_dam_sire';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'identifier',
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
