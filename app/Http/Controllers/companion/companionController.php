<?php

namespace App\Http\Controllers\companion;

use App\Http\Controllers\Controller;
use App\Models\category\categoryModel;
use App\Models\companion\companionGallery;
use App\Models\companion\companions;
use App\Models\companion\dam_sireModel;

use Illuminate\Http\Request;
use Validator;
use Session;
use DB;

class companionController extends Controller
{
    public function companions()
    {
        $companions = companions::select('t_companions.*', 'c.category_name')
            ->leftJoin('t_category as c', 't_companions.category', '=', 'c.id')
            ->where('t_companions.status', '!=', 0)
            ->get();

        return view("companion.companions", ['companions' => $companions]);
    }
    public function addCompanion()
    {
        $categories = categoryModel::where('status', 1)->get();
        return view("companion.add-companion", ['categories' => $categories]);
    }
    public function addCompanionProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companion_name' => 'required|string',
            'sex' => 'required|string',
            'category' => 'required',
            'date_of_birth' => "required",
            'source' => "required",
            'companion_image' => "required",
            'companion_video.*' => 'mimes:mp4,avi,mkv,flv|max:10240',
            'status' => "required",
        ]);

        $old_companion = companions::select('id')->orderBy('id', 'DESC')->first();

        if ($old_companion) {
            $new_companion_id = $old_companion->id + 1;
        } else {
            $new_companion_id = 1;
        }
        $companion_id = "JSF0" . date("Y") . "0" . $new_companion_id;


        if ($validator->passes()) {

            if ($request->hasFile('companion_image')) {
                $image = $request->file('companion_image');

                $originalName = $image->getClientOriginalName();
                $extension = time() . '.' . $image->getClientOriginalExtension();
                $imageName = uniqid() . "_" . $originalName;
                $path = $image->move('public/companions/' . $companion_id, $imageName);
            }

            $data = [
                'companion_id' => $companion_id,
                'name' => $request->input('companion_name'),
                'sex' => $request->input('sex'),
                'dob' => $request->input('date_of_birth'),
                'height' => $request->input('height'),
                'category' => $request->input('category'),
                'type' => $request->input('companion_type'),
                'source' => $request->input('source'),
                'purchase_date' => $request->input('purchase_date'),
                'purchase_amount' => $request->input('purchase_amount'),
                'short_description' => $request->input('short_description'),
                'description' => $request->input('description'),
                'micro_chip_number' => $request->input('micro_chip_number'),
                'image' => $path,
                'created_by' => Session::get('user')->username,
                'updated_by' => Session::get('user')->username,
                'status' => $request->input('status'),
            ];

            if ($insert = DB::table('t_companions')->insertGetId($data)) {
                $p_id = companions::where('id', $insert)->first()->companion_id;
                if ($request->hasFile('companion_gallery')) {
                    foreach ($request->file('companion_gallery') as $file) {

                        $originalName = $file->getClientOriginalName();
                        $extension = time() . '.' . $file->getClientOriginalExtension();
                        $imageName = uniqid() . "_" . $originalName;

                        $filePath = $file->move('public/companions/' . $p_id, $imageName);
                        companionGallery::create([
                            'companion_id' => $p_id,
                            'type' => 'image',
                            'file_path' => $filePath,
                            'status' => 1,
                            'created_by' => Session::get('user')->username,
                            'updated_by' => Session::get('user')->username,
                        ]);
                    }
                }

                if ($request->hasFile('companion_video')) {
                    $file = $request->file('companion_video');
                    $originalName = $file->getClientOriginalName();
                    $extension = time() . '.' . $file->getClientOriginalExtension();
                    $videoName = uniqid() . "_" . $originalName;

                    $filePath = $file->move('public/companions/' . $p_id, $videoName);
                    companionGallery::create([
                        'companion_id' => $p_id,
                        'type' => 'video',
                        'file_path' => $filePath,
                        'status' => 1,
                        'created_by' => Session::get('user')->username,
                        'updated_by' => Session::get('user')->username,
                    ]);
                }

                $damSire = json_decode($request->input('parentData'), true);
                if (!empty($damSire)) {
                    foreach ($damSire as $item) {
                        $insert = dam_sireModel::create([
                            'companion_id' => $p_id,
                            'identifier' => $item['parent'],
                            'name' => $item['parentName'],
                            'status' => 1,
                            'created_by' => Session::get('user')->username,
                            'updated_by' => Session::get('user')->username,
                        ]);
                    }
                }

                $result = [
                    "status" => "success",
                    "message" => "Companion added successfully!",
                    "companion_id" => $p_id,
                ];
                return response()->json($result);
            } else {
                $result = [
                    "status" => "error",
                    "message" => "Companion could not be added!",
                    "user" => $insert
                ];
                return response()->json($result);
            }
        } else {
            $result = [
                "status" => "error",
                "error" => $validator->errors(),
            ];
            return response()->json($result);
        }
    }


    public function updateCompanion($cID)
    {
        $categories = categoryModel::where('status', 1)->get();
        $companion = companions::where('companion_id', '=', $cID)->first();
        return view("companion.updateCompanion", ['companion' => $companion, 'categories' => $categories]);
    }
}
