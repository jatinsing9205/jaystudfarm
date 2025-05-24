<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\login\accessModel;
use App\Models\login\loginModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function users()
    {
        return view('users.users');
    }

    public function getAllUsers()
    {
        $userModel = new loginModel();
        $users = $userModel->getAllUsers();
        return response($users);
    }

    public function addUser()
    {
        $access = accessModel::where('status', 1)
            ->where('id', '!=', 1)
            ->get();
        return view('users.add-user', ['access' => $access]);
    }

    public function addUserProcess(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'username' => 'required|string|unique:t_user_login,username|regex:/^\S*$/',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:t_user_login,email',
            'access' => 'required|string',
            'password' => 'required|string',
            'status' => 'required|string',
        ]);
        if ($validation->passes()) {
            $createUser = loginModel::insertGetId([
                'username' => $request->input('username'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'access' => $request->input('access'),
                'password' => $request->input('password'),
                'status' => $request->input('status')
            ]);
            if ($createUser) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Created Successfully!',
                    'userid' => $createUser
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, user could be created!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation Failed!',
                'error' => $validation->errors()
            ]);
        }
    }

    public function editUser($uID)
    {
        $access = accessModel::where('status', 1)
            ->where('id', '!=', 1)
            ->get();
        $user = loginModel::where('id', $uID)->first();


        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        return view('users.update-user', ['user' => $user, 'access' => $access]);
    }

    public function updateUserProcess(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:t_user_login,email,' . $request->input('id'),
            'access' => 'required|string',
            'password' => 'required|string',
            'status' => 'required|string',
        ]);
        $uID = $request->input('id');
        if(!$uID){
            return response()->json([
                'status' => 'error',
                'message' => 'User ID not found!'
            ]);
        }
        if ($validation->passes()) {
            $createUser = DB::table('t_user_login')->where('id',$uID)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'access' => $request->input('access'),
                'password' => $request->input('password'),
                'status' => $request->input('status')
            ]);
            if ($createUser) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User updated Successfully!',
                    'userid' => $createUser
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'No Changes found!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation Failed!',
                'error' => $validation->errors()
            ]);
        }
    }

    public function deleteUser(Request $request, $uId)
    {
        $deleted = DB::table('t_user_login')->where('id', '=', $uId)->update(['status' => 0]);

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User could not be deleted!'
            ]);
        }
    }
}
