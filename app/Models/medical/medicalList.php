<?php

namespace App\Models\medical;

use Illuminate\Database\Eloquent\Model;

class medicalList extends Model
{
    protected $table = 't_medical_list';
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
