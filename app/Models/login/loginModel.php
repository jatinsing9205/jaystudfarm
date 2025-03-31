<?php

namespace App\Models\login;

use DB;
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


    public function getAllUsers()
    {
        return DB::table('t_user_login')
            ->leftJoin('t_access', 't_user_login.access', '=', 't_access.id')
            ->select('t_user_login.*', 't_access.access_name')
            ->get();
    }

}
