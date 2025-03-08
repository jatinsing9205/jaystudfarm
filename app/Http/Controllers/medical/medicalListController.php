<?php

namespace App\Http\Controllers\medical;

use App\Http\Controllers\Controller;
use App\Models\medical\medicalList;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class medicalListController extends Controller
{
    public function medical()
    {
        return view("medical.medicalList");
    }

    public function getAllMedicals()
    {
        $medicals = DB::table('t_medical_list')
            ->where('status', '!=', 0)
            ->get();
        return response($medicals);

    }

    public function addMedicalListProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medical_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->passes()) {
            $data = [
                'name' => $request->input('medical_name'),
                'status' => $request->input('status'),
                'created_by' => Session::get('user')->username,
                'updated_by' => Session::get('user')->username,
            ];
            if ($insert = DB::table('t_medical_list')->insert($data)) {
                $result = [
                    "status" => "success",
                    "message" => "Medical list added successfully!",
                    "user" => $insert
                ];
                return response()->json($result);
            } else {
                $result = [
                    "status" => "error",
                    "message" => "Medical list could not be added!",
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

    public function editMedical($id)
    {
        $medical = medicalList::find($id);
        return response()->json($medical);
    }

    public function updateMedicalListProcess(Request $request, $sID)
    {
        if (!$sID) {
            return redirect()->route('medical');
        }

        $validator = Validator::make($request->all(), [
            'medical_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $category = DB::table('t_medical_list')->where('id', $sID)->first();
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Medical not found!',
                'id' => $sID
            ], 404);
        }

        $data = [
            'name' => $request->input('medical_name'),
            'status' => $request->input('status'),
            'updated_by' => Session::get('user')->username,
        ];
        $update = DB::table('t_medical_list')->where('id', $sID)->update($data);

        if ($update) {
            return response()->json([
                'status' => 'success',
                'message' => 'Medical updated successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No changes found!'
            ]);
        }
    }

    public function deleteMedical(Request $request, $sID)
    {
        $deleted = DB::table('t_medical_list')->where('id', '=', $sID)->update(['status' => 0]);

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Medical deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Medical could not be deleted!'
            ]);
        }
    }
}
