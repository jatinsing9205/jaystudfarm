<?php

namespace App\Models\login;

use Illuminate\Database\Eloquent\Model;

class accessModel extends Model
{
    protected $table = "t_access";
    public $timestamps = true;
    protected $fillable = [
        'access_name',
        'status',
    ];
    protected $date = [
        'created_at',
        'updated_at',
    ];
}
