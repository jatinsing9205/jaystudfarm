<?php

namespace App\Http\Controllers\main;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class userController extends Controller
{
    public function login(){
        return view('');
    }

    public function loginCheck(Request $request){
        $result = [];
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->passes()) {
            $username = $request->input('username');
            $password = $request->input('password');

            $user = DB::table('t_users')
                ->where(function ($query) use ($username) {
                    $query->where('email', $username)
                        ->orWhere('username', $username);
                })
                ->first();

            if ($user) {
                if ($user->password == md5($password)) {
                    if ($user->status == 1) {
                        Session::put('user', $user);
                        $result = [
                            "status" => "success",
                            "message" => "Login Successful!",
                            "user" => $user->username
                        ];
                        return response()->json($result);
                    } else {
                        $result = [
                            "status" => "error",
                            "message" => "Account deactivated!",
                        ];
                        return response()->json($result);
                    }
                } else {
                    $result = [
                        "status" => "error",
                        "message" => "Invalid credentials!",
                    ];
                    return response()->json($result);
                }

            } else {
                $result = [
                    "status" => "error",
                    "message" => "User not found."
                ];
                return response()->json($result);
                ;
            }
        } else {
            $result = [
                "status" => "error",
                "error" => $validator->errors()
            ];
            return response()->json($result);
        }
    }
}
