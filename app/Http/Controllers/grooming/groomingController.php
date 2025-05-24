<?php

namespace App\Http\Controllers\grooming;

use App\Http\Controllers\Controller;
use App\Models\companion\companionLogModel;
use App\Models\grooming\companionGrooming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class groomingController extends Controller
{
    public function addCompanionGrooming($companionID)
    {
        return view('Grooming.addCompanionGrooming', ['companionID' => $companionID]);
    }
    public function getCompanionGrooming($companion_id)
    {
        $Grooming = companionGrooming::where('companion_id', '=', $companion_id)
            ->orderBy('id', "DESC")
            ->get();
        if ($Grooming) {
            return response()->json([
                "status" => "success",
                "message" => "Groomings fetched successfully!",
                "Grooming" => $Grooming,
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Could not fetch Groomings!"
            ]);
        }
    }


    public function addCompanionGroomingProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companion_id'      => 'required|string|max:50',
            'date'              => 'required|date',
            'morning_grooming'   => 'required|string',
            'evening_grooming'      => 'required|string',
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
                'morning_grooming'   => $request->input('morning_grooming'),
                'evening_grooming'   => $request->input('evening_grooming'),
                'administered_by'    => $request->input('administered_by'),
                'expected_date'      => $expectedDate,
                'created_by'         => $created_by,
                'remark'             => $request->input('remark'),
            ];
        }

        $inserted = companionGrooming::insert($records);

        if ($inserted) {
            $logs = [
                'companion_id' => $request->input('companion_id'),
                'action'       => "Add Grooming <br>" .
                    $request->input('date') . " | Morning Grooming: " .
                    $request->input('morning_grooming') . 
                    " | Evening Grooming: " . $request->input('evening_grooming') .
                    " | Administered By: " . $request->input('administered_by') .
                    " | Expected Date: " . $request->input('expected_date') . "<br>" .
                    "Remark : " . $request->input('remark'),
                'created_by'   => $created_by,
            ];
            companionLogModel::insert($logs);

            return response()->json([
                "status"  => "success",
                "message" => "Grooming records added successfully!"
            ]);
        } else {
            return response()->json([
                "status"  => "error",
                "message" => "Grooming records could not be added!"
            ]);
        }
    }
}
