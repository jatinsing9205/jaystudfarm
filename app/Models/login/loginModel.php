<?php

namespace App\Models\login;

use Illuminate\Database\Eloquent\Model;

class loginModel extends Model
{
    protected $table = 't_user_login';
    public $timestamps = true;
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'access',
        'status'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];


}
