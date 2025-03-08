<?php

namespace App\Http\Controllers\supplements;

use App\Http\Controllers\Controller;
use App\Models\category\categoryModel;
use App\Models\supplements\supplementList;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class supplementListController extends Controller
{
    public function supplement()
    {
        return view("supplements.supplementList");
    }

    public function getAllSupplements()
    {
        $supplements = DB::table('t_supplement_list')
            ->where('status', '!=', 0)
            ->get();
        return response($supplements);

    }

    public function addSupplementListProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplement_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->passes()) {
            $data = [
                'name' => $request->input('supplement_name'),
                'status' => $request->input('status'),
                'created_by' => Session::get('user')->username,
                'updated_by' => Session::get('user')->username,
            ];
            if ($insert = DB::table('t_supplement_list')->insert($data)) {
                $result = [
                    "status" => "success",
                    "message" => "Supplement added successfully!",
                    "user" => $insert
                ];
                return response()->json($result);
            } else {
                $result = [
                    "status" => "error",
                    "message" => "Supplement could not be added!",
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

    public function editSupplement($id)
    {
        $supplement = supplementList::find($id);
        return response()->json($supplement);
    }

    public function updateSupplementListProcess(Request $request, $sID)
    {
        if (!$sID) {
            return redirect()->route('supplement');
        }

        $validator = Validator::make($request->all(), [
            'supplement_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $category = DB::table('t_supplement_list')->where('id', $sID)->first();
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Supplement not found!',
                'id' => $sID
            ], 404);
        }

        $data = [
            'name' => $request->input('supplement_name'),
            'status' => $request->input('status'),
            'updated_by' => Session::get('user')->username,
        ];
        $update = DB::table('t_supplement_list')->where('id', $sID)->update($data);

        if ($update) {
            return response()->json([
                'status' => 'success',
                'message' => 'Supplement updated successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No changes found!'
            ]);
        }
    }

    public function deleteSupplement(Request $request, $sID)
    {
        $deleted = DB::table('t_supplement_list')->where('id', '=', $sID)->update(['status' => 0]);

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Supplement deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Supplement could not be deleted!'
            ]);
        }
    }

}
