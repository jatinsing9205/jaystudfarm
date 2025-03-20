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
            'companion_image' => 'required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:1024',
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
                    foreach ($request->file('companion_video') as $file) {
                        // $file = $request->file('companion_video');
                        $originalName = $file->getClientOriginalName();
                        $extension = time() . '.' . $file->getClientOriginalExtension();
                        $videoName = uniqid() . "_" . $originalName;

                        $filePath = $file->move('public/companions/' . $companion_id, $videoName);
                        $iVideo = companionGallery::create([
                            'companion_id' => $companion_id,
                            'type' => 'video',
                            'file_path' => $filePath,
                            'status' => 1,
                            'created_by' => Session::get('user')->username,
                            'updated_by' => Session::get('user')->username,
                        ]);
                    }
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
        $companionModel = new companions();
        $companion = $companionModel->companionDetails($cID);
        $companion = $companion[0];
        $categories = categoryModel::where('status', 1)->get();
        return view("companion.updateCompanion", ['companion' => $companion, 'categories' => $categories]);
    }

    public function deleteGalleryImage(Request $request, $gID)
    {
        $deleted = companionGallery::where('id', '=', $gID)->update(['status' => 0]);

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Image deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Image could not be deleted!'
            ]);
        }
    }

    public function deleteGalleryVideo(Request $request, $gID)
    {
        $deleted = companionGallery::where('id', '=', $gID)->update(['status' => 0]);

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Video deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Video could not be deleted!'
            ]);
        }
    }

    public function deleteDamSire(Request $request, $dsID)
    {
        $deleted = dam_sireModel::where('id', '=', $dsID)->update(['status' => 0]);

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Dam/Sire deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Dam/Sire could not be deleted!'
            ]);
        }
    }

    public function updateCompanionProcess(Request $request, $companion_id)
    {
        $validator = Validator::make($request->all(), [
            'companion_name' => 'required|string',
            'sex' => 'required|string',
            'category' => 'required',
            'date_of_birth' => "required",
            'source' => "required",
            'companion_image' => 'image|mimes:webp,jpeg,png,jpg,gif,svg',
            'companion_video.*' => 'mimes:mp4,avi,mkv,flv|max:10240',
            'status' => "required",
        ]);


        if ($validator->passes()) {
            $data = [
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
                'updated_by' => Session::get('user')->username,
                'status' => $request->input('status'),
            ];
            $update = false;
            $iDamSire = false;
            $igallery = false;
            $iVideo = false;
            if ($request->hasFile('companion_image')) {
                $image = $request->file('companion_image');

                $originalName = $image->getClientOriginalName();
                $extension = time() . '.' . $image->getClientOriginalExtension();
                $imageName = uniqid() . "_" . $originalName;
                $path = $image->move('public/companions/' . $companion_id, $imageName);
                $data['image'] = $path;
            }

            $update = DB::table('t_companions')->where("companion_id", $companion_id)->update($data);

            if ($request->hasFile('companion_gallery')) {
                foreach ($request->file('companion_gallery') as $file) {

                    $originalName = $file->getClientOriginalName();
                    $extension = time() . '.' . $file->getClientOriginalExtension();
                    $imageName = uniqid() . "_" . $originalName;

                    $filePath = $file->move('public/companions/' . $companion_id, $imageName);
                    $igallery = companionGallery::create([
                        'companion_id' => $companion_id,
                        'type' => 'image',
                        'file_path' => $filePath,
                        'status' => 1,
                        'created_by' => Session::get('user')->username,
                        'updated_by' => Session::get('user')->username,
                    ]);
                }
            }

            if ($request->hasFile('companion_video')) {
                foreach ($request->file('companion_video') as $file) {
                    // $file = $request->file('companion_video');
                    $originalName = $file->getClientOriginalName();
                    $extension = time() . '.' . $file->getClientOriginalExtension();
                    $videoName = uniqid() . "_" . $originalName;

                    $filePath = $file->move('public/companions/' . $companion_id, $videoName);
                    $iVideo = companionGallery::create([
                        'companion_id' => $companion_id,
                        'type' => 'video',
                        'file_path' => $filePath,
                        'status' => 1,
                        'created_by' => Session::get('user')->username,
                        'updated_by' => Session::get('user')->username,
                    ]);
                }
            }

            $damSire = json_decode($request->input('parentData'), true);
            if (!empty($damSire)) {
                foreach ($damSire as $item) {
                    if (isset($item['DamSireId']) && !empty($item['DamSireId'])) {
                        $iDamSire = dam_sireModel::where("id", "=", $item['DamSireId'])->update([
                            'identifier' => $item['parent'],
                            'name' => $item['parentName'],
                            'updated_by' => Session::get('user')->username,
                        ]);
                    } else {
                        $iDamSire = dam_sireModel::create([
                            'companion_id' => $companion_id,
                            'identifier' => $item['parent'],
                            'name' => $item['parentName'],
                            'status' => 1,
                            'created_by' => Session::get('user')->username,
                            'updated_by' => Session::get('user')->username,
                        ]);
                    }
                }
            }

            if ($update || $iDamSire || $igallery || $iVideo) {
                $result = [
                    "status" => "success",
                    "message" => "Companion updated successfully!",
                    "companion_id" => $companion_id,
                ];
            } else {
                $result = [
                    "status" => "error",
                    "message" => "No Changes Found!",
                    "companion_id" => $companion_id,
                ];
            }

        } else {
            $result = [
                "status" => "error",
                "error" => $validator->errors(),
            ];
        }
        return response()->json($result);
    }

    public function viewCompanion($companion_id)
    {
        $companionModel = new companions();
        $companion = $companionModel->companionDetails($companion_id);
        $companion = $companion[0];
        return view("companion/viewCompanion", ['companion' => $companion]);
    }
}
