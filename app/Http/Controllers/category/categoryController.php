<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use App\Models\category\categoryModel;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class categoryController extends Controller
{
    public function category()
    {
        $categories = DB::table('t_category')
            ->select('*')
            ->get();
        return view("category.category", ['categories' => $categories]);
    }


    public function getAllCategory()
    {
        $categories = DB::table('t_category as c1')
            ->leftJoin('t_category as c2', 'c1.parent_id', '=', 'c2.id')
            ->where('c1.status', '!=', 0)
            ->select('c1.*', 'c2.category_name as parent_name')
            ->get();

        return response()->json($categories);

    }

    public function addCategoryProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->passes()) {
            $data = [
                'category_name' => $request->input('category_name'),
                'parent_id' => $request->input('parent_category'),
                'status' => $request->input('status'),
                'created_by' => Session::get('user')->username,
                'updated_by' => Session::get('user')->username,
            ];
            if ($insert = DB::table('t_category')->insert($data)) {
                $result = [
                    "status" => "success",
                    "message" => "Category added successfully!",
                    "user" => $insert
                ];
                return response()->json($result);
            } else {
                $result = [
                    "status" => "error",
                    "message" => "Category could not be added!",
                    "user" => $insert
                ];
                return response()->json($result);
            }
        } else {
            $result = [
                "status" => "error",
                "error" => $validator->errors()
            ];
            return response()->json($result);
        }
    }


    public function updateCategory(Request $request, $cID)
    {
        if (!$cID) {
            return redirect()->route('addCategory');
        }

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $category = DB::table('t_category')->where('id', $cID)->first();
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found!',
                'id' => $cID
            ], 404);
        }

        $data = [
            'category_name' => $request->input('category_name'),
            'parent_id' => $request->input('parent_category'),
            'status' => $request->input('status'),
            'updated_by' => Session::get('user')->username,
        ];
        $update = DB::table('t_category')->where('id', $cID)->update($data);

        if ($update) {
            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No changes found!'
            ]);
        }
    }


    public function deleteCategory(Request $request, $cId)
    {
        $deleted = DB::table('t_category')->where('id', '=', $cId)->update(['status' => 0]);

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Category could not be deleted!'
            ]);
        }
    }

    public function editCategory($id)
    {
        $category = categoryModel::find($id);
        return response()->json($category);
    }



}

