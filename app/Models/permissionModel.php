<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permissionModel extends Model
{
    protected $table = 't_permissions';
    public $timestamps = true;
    protected $fillable = [ 
        'name', 
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
