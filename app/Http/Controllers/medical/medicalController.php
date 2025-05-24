<?php

namespace App\Http\Controllers\medical;

use App\Http\Controllers\Controller;
use App\Models\companion\companionLogModel;
use App\Models\medical\companionMedical;
use App\Models\medical\medicalList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class medicalController extends Controller
{

    public function addCompanionMedical($companionID)
    {
        return view('medical.addCompanionMedical', ['companionID' => $companionID]);
    }

    public function getCompanionMedical($companion_id)
    {
        $medicals = companionMedical::join("t_medical_list", "t_companion_medical.treated_for", "=", "t_medical_list.id")
            ->where('t_companion_medical.companion_id', '=', $companion_id)
            ->select('t_medical_list.name as medical', "t_companion_medical.*")
            ->orderBy('t_companion_medical.id', "DESC")
            ->get();
        if ($medicals) {
            return response()->json([
                "status" => "success",
                "message" => "Medical Added Successfully!",
                "medicals" => $medicals,
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Medical could not be added!"
            ]);
        }
    }

    public function addCompanionMedicalProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companion_id'      => 'required|string|max:50',
            'date'              => 'required|date',
            'treated_for'              => 'required|string|max:255',
            'medication_given'      => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"  => "error",
                "message" => "Please fill required fields!",
                "error"   => $validator->errors()
            ]);
        }
        $expectedDates = array_map('trim', explode(',', $request->input('next_date_of_follow_up_treatment')));
        if (!empty($request->input('next_date_of_follow_up_treatment'))) {
            foreach ($expectedDates as $date) {
                if (!\DateTime::createFromFormat('d-m-Y', $date)) {
                    return response()->json([
                        "status"  => "error",
                        "message" => "Invalid date format in expected_date: $date. Expected format: dd-mm-yyyy",
                    ]);
                }
            }
        }

        $records = [];

        foreach ($expectedDates as $expectedDate) {
            $records[] = [
                'companion_id' => $request->input('companion_id'),
                'date' => $request->input('date'),
                'treated_for' => $request->input('treated_for'),
                'medication_given' => $request->input('medication_given'),
                'next_followup_date' => $expectedDate,
                'next_followup_remark' => $request->input('next_follow_up_remark'),
                'doctor_remark' => $request->input('doctor_remark'),
                'created_by' => Session::get('user')->username,
            ];
        }


        $insert = companionMedical::insert($records);
        $medical = medicalList::where('id', $request->input('treated_for'))->select('name')->first();
        $medical_name = $medical ? $medical->name : '';

        if ($insert) {
            $log = "Add Medical <br>" .
                $request->input('date') . " | " .
                $medical_name . " | " . " Medication Given: " . $request->input('medication_given') . " | " .
                " Follow Up Date: " . $request->input('next_date_of_follow_up_treatment') . "<br>" .
                " Next Followup Remark: " . $request->input('next_follow_up_remark') . "<br>" .
                " Doctor's Remark: " . $request->input('doctor_remark');

            $createLog = companionLogModel::insertGetId([
                'companion_id' => $request->input('companion_id'),
                'action' => $log,
                'created_by' => Session::get('user')->username,
            ]);
            if ($createLog) {
                return response()->json([
                    "status" => "success",
                    "message" => "Medical Added Successfully!"
                ]);
            } else {
                return response()->json([
                    "status" => "success",
                    "message" => "Medical added but Logs could not be created!"
                ]);
            }
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Medical could not be added!"
            ]);
        }
    }
}
