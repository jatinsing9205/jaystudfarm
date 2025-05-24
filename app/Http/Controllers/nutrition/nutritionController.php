<?php

namespace App\Http\Controllers\nutrition;

use App\Http\Controllers\Controller;
use App\Models\companion\companionLogModel;
use App\Models\nutrition\companionNutrition;
use App\Models\nutrition\nutritionList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class nutritionController extends Controller
{

    public function addCompanionNutrition($companionID)
    {
        return view('nutrition.addCompanionNutrition', ['companionID' => $companionID]);
    }

    public function getCompanionNutrition($companion_id)
    {
        $nutritions = companionNutrition::join("t_nutrition_list", "t_companion_nutrition.food", "=", "t_nutrition_list.id")
            ->where('t_companion_nutrition.companion_id', '=', $companion_id)
            ->select('t_nutrition_list.name as nutrition', "t_companion_nutrition.*")
            ->orderBy('t_companion_nutrition.id', "DESC")
            ->get();
        if ($nutritions) {
            return response()->json([
                "status" => "success",
                "message" => "Nutrition Added Successfully!",
                "nutritions" => $nutritions,
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Nutrition could not be added!"
            ]);
        }
    }

    public function addCompanionNutritionProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companion_id'      => 'required|string|max:50',
            'date'              => 'required|date',
            'food'              => 'required|string|max:255',
            'measure_unit'      => 'required|string|max:50',
            'quantity'          => 'required|numeric|min:0',
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



        $nutrition = nutritionList::where('id', $request->input('food'))->select('name')->first();
        $nutrition_name = $nutrition ? $nutrition->name : '';
        $created_by = Session::get('user')->username;

        $records = [];

        foreach ($expectedDates as $expectedDate) {
            $records[] = [
                'companion_id'       => $request->input('companion_id'),
                'date'               => $request->input('date'),
                'food'               => $request->input('food'),
                'quantity'           => $request->input('quantity'),
                'unit'               => $request->input('measure_unit'),
                'first_feed_timing'  => $request->input('time_first_feed'),
                'second_feed_timing' => $request->input('time_second_feed'),
                'expected_date'      => $expectedDate,
                'administered_by'    => $request->input('administered_by'),
                'created_by'         => $created_by,
                'remark'             => $request->input('remark'),
            ];
        }

        $inserted = companionNutrition::insert($records);

        if ($inserted) {
            $logs = [
                'companion_id' => $request->input('companion_id'),
                'action'       => "Add Nutrition <br>" .
                    $request->input('date') . " | " .
                    $nutrition_name . " | " .
                    $request->input('quantity') . " " . $request->input('measure_unit') . " | " .
                    " f_time: " . $request->input('time_first_feed') .
                    " | s_time: " . $request->input('time_second_feed') .
                    " | Expected Date: " . $request->input('expected_date') . "<br>" .
                    "Remark : " . $request->input('remark'),
                'created_by'   => $created_by,
            ];
            companionLogModel::insert($logs);

            return response()->json([
                "status"  => "success",
                "message" => "Nutrition records added successfully!"
            ]);
        } else {
            return response()->json([
                "status"  => "error",
                "message" => "Nutrition records could not be added!"
            ]);
        }
    }
}
