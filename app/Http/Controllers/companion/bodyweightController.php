<?php

namespace App\Http\Controllers\companion;

use App\Http\Controllers\Controller;
use App\Models\companion\companionBodyweight;
use App\Models\companion\companionLogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class bodyweightController extends Controller
{
    public function addCompanionBodyweight($companionID)
    {
        return view('bodyWeight.addCompanionBodyweight', ['companionID' => $companionID]);
    }
    public function getCompanionBodyweight($companion_id)
    {
        $Bodyweight = companionBodyweight::where('companion_id', '=', $companion_id)
            ->orderBy('id', "DESC")
            ->get();
        if ($Bodyweight) {
            return response()->json([
                "status" => "success",
                "message" => "Bodyweights fetched successfully!",
                "Bodyweight" => $Bodyweight,
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Could not fetch Bodyweights!"
            ]);
        }
    }
    public function addCompanionBodyweightProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companion_id'      => 'required|string|max:50',
            'date'              => 'required|date',
            'weight'   => 'required|string',
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



        $created_by = Session::get('user')->username;
        $records = [];

        foreach ($expectedDates as $expectedDate) {
            $records[] = [
                'companion_id'       => $request->input('companion_id'),
                'date'               => $request->input('date'),
                'body_weight'   => $request->input('weight'),
                'checked_by'    => $request->input('checked_by'),
                'expected_date'      => $expectedDate,
                'created_by'         => $created_by,
                'remark'             => $request->input('remark'),
            ];
        }

        $inserted = companionBodyweight::insert($records);

        if ($inserted) {
            $logs = [
                'companion_id' => $request->input('companion_id'),
                'action'       => "Add Bodyweight <br>" .
                    $request->input('date') . " | Weight: " .
                    $request->input('weight') . "Kg " .
                    " | Checked By: " . $request->input('checked_by') .
                    " | Expected Date: " . $request->input('expected_date') . "<br>" .
                    "Remark : " . $request->input('remark'),
                'created_by'   => $created_by,
            ];
            companionLogModel::insert($logs);

            return response()->json([
                "status"  => "success",
                "message" => "Bodyweight records added successfully!"
            ]);
        } else {
            return response()->json([
                "status"  => "error",
                "message" => "Bodyweight records could not be added!"
            ]);
        }
    }
}
