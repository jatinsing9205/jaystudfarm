<?php

namespace App\Http\Controllers;

use App\Models\permissionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class permissionsController extends Controller
{
    public function view()
    {
        $permissions = permissionModel::all();
        return view('permissions.view', ['permissions' => $permissions]);
    }

    public function add()
    {
        return view('permissions.add');
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validation->errors(),
            ]);
        }

        $data = [
            'name' => $request->name,
            'created_by' => Session::get('user')->username,
        ];

        // test response first
        $insertedId = permissionModel::create($data)->id;

        if ($insertedId) {
            return response()->json([
                'status' => 'success',
                'message' => 'Permission added successfully',
                'inserted_id' => $insertedId,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add permission',
            ]);
        }
    }


    public function edit($id)
    {
        $permission = permissionModel::find($id);
        return view('permissions.edit', ['permission' => $permission]);
    }


    public function delete($id)
    {
        if (!$id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid ID',
            ]);
        }
        $permission = permissionModel::find($id);
        if ($permission) {
            $permission->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Permission deleted successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission not found',
            ]);
        }
    }
}
