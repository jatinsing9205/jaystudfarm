<?php

namespace App\Http\Controllers\nutrition;

use App\Http\Controllers\Controller;
use App\Models\nutrition\nutritionList;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class nutritionListController extends Controller
{
    public function nutrition()
    {
        return view("nutrition.nutritionList");
    }

    public function getAllNutritions()
    {
        $nutritions = DB::table('t_nutrition_list')
            ->where('status', '!=', 0)
            ->get();
        return response($nutritions);

    }

    public function addNutritionListProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nutrition_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->passes()) {
            $data = [
                'name' => $request->input('nutrition_name'),
                'status' => $request->input('status'),
                'created_by' => Session::get('user')->username,
                'updated_by' => Session::get('user')->username,
            ];
            if ($insert = DB::table('t_nutrition_list')->insert($data)) {
                $result = [
                    "status" => "success",
                    "message" => "Nutrition added successfully!",
                    "user" => $insert
                ];
                return response()->json($result);
            } else {
                $result = [
                    "status" => "error",
                    "message" => "Nutrition could not be added!",
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

    public function editNutrition($id)
    {
        $nutrition = nutritionList::find($id);
        return response()->json($nutrition);
    }

    public function updateNutritionListProcess(Request $request, $sID)
    {
        if (!$sID) {
            return redirect()->route('nutrition');
        }

        $validator = Validator::make($request->all(), [
            'nutrition_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $category = DB::table('t_nutrition_list')->where('id', $sID)->first();
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nutrition not found!',
                'id' => $sID
            ], 404);
        }

        $data = [
            'name' => $request->input('nutrition_name'),
            'status' => $request->input('status'),
            'updated_by' => Session::get('user')->username,
        ];
        $update = DB::table('t_nutrition_list')->where('id', $sID)->update($data);

        if ($update) {
            return response()->json([
                'status' => 'success',
                'message' => 'Nutrition updated successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No changes found!'
            ]);
        }
    }

    public function deleteNutrition(Request $request, $sID)
    {
        $deleted = DB::table('t_nutrition_list')->where('id', '=', $sID)->update(['status' => 0]);

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Nutrition deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Nutrition could not be deleted!'
            ]);
        }
    }
}
