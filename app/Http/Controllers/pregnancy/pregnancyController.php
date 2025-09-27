<?php

namespace App\Http\Controllers\pregnancy;

use App\Http\Controllers\Controller;
use App\Models\companion\companionLogModel;
use App\Models\pregnancy\companionPregnancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class pregnancyController extends Controller
{
    public function addCompanionPregnancy($companionID)
    {
        return view('pregnancy.addCompanionPregnancy', ['companionID' => $companionID]);
    }
    public function getCompanionPregnancy($companion_id)
    {
        $Pregnancy = companionPregnancy::where('companion_id', '=', $companion_id)
            ->orderBy('id', "DESC")
            ->get();
        if ($Pregnancy) {
            return response()->json([
                "status" => "success",
                "message" => "Pregnancy fetched successfully!",
                "Pregnancy" => $Pregnancy,
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Could not fetch Pregnancy!"
            ]);
        }
    }
    public function addCompanionPregnancyProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companion_id'      => 'required|string|max:50',
            'date'              => 'required|date',
            'heat'   => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"  => "error",
                "message" => "Please fill required fields!",
                "error"   => $validator->errors()
            ]);
        }

        $expectedDate = $request->input('next_expected_date');
        $created_by = Session::get('user')->username;
        $records = [];

        $records[] = [
            'companion_id'       => $request->input('companion_id'),
            'date'               => $request->input('date'),
            'heat'   => $request->input('heat'),
            'miss_heat'   => $request->input('miss_heat'),
            'mating'    => $request->input('mating'),
            'mating_date'    => $request->input('mating_date'),
            'companion_used'    => $request->input('companion_used'),
            'expected_date'      => $expectedDate,
            'created_by'         => $created_by,
            'remark'             => $request->input('remark'),
        ];

        $inserted = companionPregnancy::insert($records);

        if ($inserted) {
            $logs = [
                'companion_id' => $request->input('companion_id'),
                'action'       => "Add Pregnancy <br>" .
                    $request->input('date') . " | Heat: " .
                    $request->input('heat') .
                    " | Miss Heat: " . $request->input('miss_heat') .
                    " | Mating: " . $request->input('mating') .
                    " | Mating Date: " . $request->input('mating_date') .
                    " | Companion Used: " . $request->input('companion_used') .
                    " | Expected Date: " . $request->input('next_expected_date') . "<br>" .
                    "Remark : " . $request->input('remark'),
                'created_by'   => $created_by,
            ];
            companionLogModel::insert($logs);

            return response()->json([
                "status"  => "success",
                "message" => "Pregnancy records added successfully!"
            ]);
        } else {
            return response()->json([
                "status"  => "error",
                "message" => "Pregnancy records could not be added!"
            ]);
        }
    }
}
