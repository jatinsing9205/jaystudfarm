<?php

namespace App\Http\Controllers\supplements;

use App\Http\Controllers\Controller;
use App\Models\companion\companionLogModel;
use App\Models\supplements\companionSupplements;
use App\Models\supplements\supplementList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class supplementController extends Controller
{
    public function addCompanionSupplement($companionID)
    {
        return view('supplements.addCompanionSupplement', ['companionID' => $companionID]);
    }

    public function getCompanionSupplement($companion_id)
    {
        $supplements = CompanionSupplements::join("t_supplement_list", "t_companion_supplements.supplement", "=", "t_supplement_list.id")
            ->where('t_companion_supplements.companion_id', '=', $companion_id)
            ->select('t_supplement_list.name as supplement_name', 't_companion_supplements.*')
            ->orderBy('t_companion_supplements.id', "DESC")
            ->get();

        if ($supplements) {
            return response()->json([
                "status" => "success",
                "message" => "Companion supplements retrieved successfully!",
                "supplements" => $supplements,
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "No supplement records found."
            ]);
        }
    }


    public function addCompanionSupplementProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companion_id'      => 'required|string|max:50',
            'date'              => 'required|date',
            'supplement'              => 'required|string|max:255',
            'measure_unit'      => 'required|string|max:50',
            'quantity'          => 'required|numeric|min:0',
            'expected_date'     => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Please fill required fields!",
                "error" => $validator->errors()
            ]);
        }

        $expectedDates = array_map('trim', explode(',', $request->input('expected_date')));
        if (!empty($request->input('expected_date'))) {
            foreach ($expectedDates as $date) {
                if (!\DateTime::createFromFormat('d-m-Y', $date)) {
                    return response()->json([
                        "status"  => "error",
                        "message" => "Invalid date format in Expected Date: $date. Expected format: dd-mm-yyyy",
                    ]);
                }
            }
        }

        $records = [];

        foreach ($expectedDates as $expectedDate) {
            $records[] = [
                'companion_id' => $request->input('companion_id'),
                'date' => $request->input('date'),
                'supplement' => $request->input('supplement'),
                'quantity' => $request->input('quantity'),
                'unit' => $request->input('measure_unit'),
                'time' => $request->input('time'),
                'expected_date' => $expectedDate,
                'administered_by' => $request->input('administered_by'),
                'remark' => $request->input('remark'),
                'created_by' => Session::get('user')->username,
                'remark' => $request->input('remark'),
            ];
        }

        $insert = companionSupplements::insert($records);
        $supplement = supplementList::where('id', $request->input('supplement'))->select('name')->first();
        $supplement_name = $supplement ? $supplement->name : '';

        if ($insert) {
            $log = "Add Supplement <br>" .
                $request->input('date') . " | " .
                $supplement_name . " | " .
                $request->input('quantity') . " " . $request->input('measure_unit') . " | " .
                " time: " . $request->input('time') .
                " A_by: " . $request->input('administered_by') .
                " | Expected Date: " . $request->input('expected_date') . "<br>" .
                "Remark : " . $request->input('remark');

            $createLog = companionLogModel::insertGetId([
                'companion_id' => $request->input('companion_id'),
                'action' => $log,
                'created_by' => Session::get('user')->username,
            ]);

            return response()->json([
                "status" => "success",
                "message" => "Supplement Added Successfully!"
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Supplement could not be added!"
            ]);
        }
    }
}
