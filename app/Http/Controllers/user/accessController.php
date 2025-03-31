<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\login\accessModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class accessController extends Controller
{
    public function access()
    {
        return view("users.access");
    }

    public function getAllAccess()
    {
        $accesss = DB::table('t_access')
            ->where('status', '!=', 0)
            ->get();
        return response($accesss);

    }

    public function addAccessProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'access_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->passes()) {
            $data = [
                'access_name' => $request->input('access_name'),
                'status' => $request->input('status'),
            ];
            if ($insert = DB::table('t_access')->insert($data)) {
                $result = [
                    "status" => "success",
                    "message" => "Access  added successfully!",
                    "user" => $insert
                ];
                return response()->json($result);
            } else {
                $result = [
                    "status" => "error",
                    "message" => "Access  could not be added!",
                    "user" => $insert
                ];
                return response()->json($result);
            }
        } else {
            $result = [
                "status" => "error",
                "error" => $validator->errors()
            ];
            return response()->json($result);
        }
    }

    public function editAccess($id)
    {
        $access = accessModel::find($id);
        return response()->json($access);
    }

    public function updateAccessProcess(Request $request, $aID)
    {
        if (!$aID) {
            return redirect()->route('access');
        }

        $validator = Validator::make($request->all(), [
            'access_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $category = DB::table('t_access')->where('id', $aID)->first();
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'access not found!',
                'id' => $aID
            ]);
        }

        $data = [
            'access_name' => $request->input('access_name'),
            'status' => $request->input('status'),
        ];
        $update = DB::table('t_access')->where('id', $aID)->update($data);

        if ($update) {
            return response()->json([
                'status' => 'success',
                'message' => 'Access updated successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No changes found!'
            ]);
        }
    }

    public function deleteaccess(Request $request, $aID)
    {
        $deleted = DB::table('t_access')->where('id', '=', $aID)->update(['status' => 0]);

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Access deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Access could not be deleted!'
            ]);
        }
    }
}
