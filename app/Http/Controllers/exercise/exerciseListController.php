<?php

namespace App\Http\Controllers\exercise;

use App\Http\Controllers\Controller;
use App\Models\exercise\exerciseList;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class exerciseListController extends Controller
{
    public function exercise()
    {
        return view("exercise.exerciseList");
    }

    public function getAllExercises()
    {
        $exercises = DB::table('t_exercise_list')
            ->where('status', '!=', 0)
            ->get();

        return response()->json($exercises);

    }

    public function addExerciseListProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exercise_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->passes()) {
            $data = [
                'name' => $request->input('exercise_name'),
                'status' => $request->input('status'),
                'created_by' => Session::get('user')->username,
                'updated_by' => Session::get('user')->username,
            ];
            if ($insert = DB::table('t_exercise_list')->insert($data)) {
                $result = [
                    "status" => "success",
                    "message" => "Exercise list added successfully!",
                    "user" => $insert
                ];
                return response()->json($result);
            } else {
                $result = [
                    "status" => "error",
                    "message" => "Exercise list could not be added!",
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

    public function editExercise($id)
    {
        $exercises = exerciseList::find($id);
        return response()->json($exercises);
    }

    public function updateExerciseListProcess(Request $request, $eID)
    {
        if (!$eID) {
            return redirect()->route('exercise');
        }

        $validator = Validator::make($request->all(), [
            'exercise_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $category = DB::table('t_exercise_list')->where('id', $eID)->first();
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Medical not found!',
                'id' => $eID
            ], 404);
        }

        $data = [
            'name' => $request->input('exercise_name'),
            'status' => $request->input('status'),
            'updated_by' => Session::get('user')->username,
        ];
        $update = DB::table('t_exercise_list')->where('id', $eID)->update($data);

        if ($update) {
            return response()->json([
                'status' => 'success',
                'message' => 'Exercise updated successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No changes found!'
            ]);
        }
    }

    public function deleteExercise(Request $request, $sID)
    {
        $deleted = DB::table('t_exercise_list')->where('id', '=', $sID)->update(["status" => 0]);

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Exercise deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Exercise could not be deleted!'
            ]);
        }
    }
}
