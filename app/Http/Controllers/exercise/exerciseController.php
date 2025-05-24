<?php

namespace App\Http\Controllers\exercise;

use App\Http\Controllers\Controller;
use App\Models\companion\companionLogModel;
use App\Models\exercise\companionExercise;
use App\Models\exercise\exerciseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class exerciseController extends Controller
{
    public function addCompanionExercise($companionID)
    {
        return view('exercise.addCompanionExercise', ['companionID' => $companionID]);
    }
    public function getCompanionExercise($companion_id)
    {
        $exercise = companionExercise::join("t_exercise_list", "t_companion_exercise.exercise", "=", "t_exercise_list.id")
            ->where('t_companion_exercise.companion_id', '=', $companion_id)
            ->select('t_exercise_list.name as exercise_name', "t_companion_exercise.*")
            ->orderBy('t_companion_exercise.id', "DESC")
            ->get();
        if ($exercise) {
            return response()->json([
                "status" => "success",
                "message" => "Exercises fetched successfully!",
                "exercise" => $exercise,
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Could not fetch exercises!"
            ]);
        }
    }


    public function addCompanionExerciseProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companion_id'      => 'required|string|max:50',
            'date'              => 'required|date',
            'exercise'              => 'required|string|max:255',
            'time_spent'      => 'required|string',
            'given_by'         => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"  => "error",
                "message" => "Please fill required fields!",
                "error"   => $validator->errors()
            ]);
        }

        $expectedDates = array_map('trim', explode(',', $request->input('expected_date')));
        if (!empty($request->input('expected_date'))) {
            foreach ($expectedDates as $date) {
                if (!\DateTime::createFromFormat('d-m-Y', $date)) {
                    return response()->json([
                        "status"  => "error",
                        "message" => "Invalid date format in expected_date: $date. Expected format: dd-mm-yyyy",
                    ]);
                }
            }
        }



        $Exercise = exerciseList::where('id', $request->input('exercise'))->select('name')->first();
        $Exercise_name = $Exercise ? $Exercise->name : '';
        $created_by = Session::get('user')->username;

        $records = [];

        foreach ($expectedDates as $expectedDate) {
            $records[] = [
                'companion_id'       => $request->input('companion_id'),
                'date'               => $request->input('date'),
                'exercise'               => $request->input('exercise'),
                'time_spent'           => $request->input('time_spent'),
                'given_by'               => $request->input('given_by'),
                'monitored_by'  => $request->input('monitored_by'),
                'expected_date'      => $expectedDate,
                'created_by'         => $created_by,
                'remark'             => $request->input('remark'),
            ];
        }

        $inserted = companionExercise::insert($records);

        if ($inserted) {
            $logs = [
                'companion_id' => $request->input('companion_id'),
                'action'       => "Add Exercise <br>" .
                    $request->input('date') . " | " .
                    $Exercise_name . " | " .
                    $request->input('time_spent') .
                    " | Given By: " . $request->input('given_by') .
                    " | Monitored By: " . $request->input('monitored_by') .
                    " | Expected Date: " . $request->input('expected_date') . "<br>" .
                    "Remark : " . $request->input('remark'),
                'created_by'   => $created_by,
            ];
            companionLogModel::insert($logs);

            return response()->json([
                "status"  => "success",
                "message" => "Exercise records added successfully!"
            ]);
        } else {
            return response()->json([
                "status"  => "error",
                "message" => "Exercise records could not be added!"
            ]);
        }
    }
}
