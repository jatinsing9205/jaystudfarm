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
            'exercise_name' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'error' => $validator->errors()]);
        }
        $insert = DB::table('t_exercise_list')->insertGetId([
            'name' => $request->input('exercise_name'),
            'status' => $request->input('status'),
            'created_by' => Session::get('user')->username,
            'updated_by' => Session::get('user')->username,
        ]);
        if ($insert) {
            return response()->json(['status' => 'success', 'message' => 'Exercise Added Successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }

    public function editExercise($eID)
    {
        if (!$eID) {
            return response()->json(['status' => 'success', 'message' => "Exercise not found!"]);
        }
        $exercise = DB::table('t_exercise_list')
            ->where('id', $eID)
            ->first();
        if (!$exercise) {
            return response()->json(['status' => 'success', 'message' => "Exercise not found!"]);
        }
        return response()->json($exercise);

    }

    public function updateExerciseListProcess(Request $request,$eId){
        $validator = Validator::make($request->all(), [
            'exercise_name' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'error' => $validator->errors()]);
        }
        $update = DB::table('t_exercise_list')
            ->where('id', $eId)
            ->update([
                'name' => $request->input('exercise_name'),
                'status' => $request->input('status'),
                'updated_by' => Session::get('user')->username,
            ]);
        if ($update) {
            return response()->json(['status' => 'success', 'message' => 'Exercise Updated Successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'No changes found!']);
        }
    }

    public function deleteExercise(Request $request,$eId){
        if (!$eId) {
            return response()->json(['status' => 'success', 'message' => "Error id not found!"]);
        }
        $delete = DB::table('t_exercise_list')
            ->where('id', $eId)
            ->update([
                'status' => 0,
                'updated_by' => Session::get('user')->username,
            ]);
        if ($delete) {
            return response()->json(['status' => 'success', 'message' => 'Exercise Deleted Successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }

    }

}
