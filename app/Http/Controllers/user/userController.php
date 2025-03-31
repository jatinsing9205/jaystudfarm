<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\login\loginModel;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function users(){
        $userModel = new loginModel();
        $users = $userModel->getAllUsers();
        return view('users.users',['users' => $users]);
    }
}
