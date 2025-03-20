<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\category\categoryModel;
use App\Models\product\productGalleryModel;
use App\Models\product\productModel;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class productController extends Controller
{
    public function products()
    {
        $productModel = new productModel();
        $products = $productModel->allProducts(); 
        return view('product.product', ['products' => $products]);
    }
    public function addProduct()
    {
        $categories = categoryModel::where('status', 1)->get();
        return view('product.addProduct', ['categories' => $categories]);
    }
    public function addProductProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_title' => 'required|string',
            'price' => 'required|string',
            'product_image' => 'required',
        ]);

        $product_id = "PROD" . time() . rand(0, 9);
        if ($validator->passes()) {
            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');

                $originalName = $image->getClientOriginalName();
                $extension = time() . '.' . $image->getClientOriginalExtension();
                $imageName = uniqid() . "_" . $originalName;
                $path = $image->move('public/products/' . $product_id, $imageName);
            }
            $data = [
                'product_id' => $product_id,
                'product_title' => $request->input('product_title'),
                'product_category' => $request->input('product_category'),
                'product_price' => $request->input('price'),
                'product_sale_price' => $request->input('sale_price'),
                'product_short_description' => $request->input('short_description'),
                'product_description' => $request->input('description'),
                'product_image' => $path,
                'created_by' => Session::get('user')->username,
                'status' => $request->input('status')
            ];
            if ($insert = DB::table('t_products')->insertGetId($data)) {
                $p_id = productModel::where('id', $insert)->first()->product_id;
                if ($request->hasFile('product_gallery')) {
                    foreach ($request->file('product_gallery') as $file) {

                        $originalName = $file->getClientOriginalName();
                        $extension = time() . '.' . $file->getClientOriginalExtension();
                        $imageName = uniqid() . "_" . $originalName;

                        $filePath = $file->move('public/products/' . $p_id, $imageName);
                        productGalleryModel::create([
                            'product_id' => $p_id,
                            'file_path' => $filePath,
                            'created_by' => Session::get('user')->username,
                        ]);
                    }
                }
                $result = [
                    "status" => "success",
                    "message" => "Product added successfully!",
                    "user" => $p_id
                ];
                return response()->json($result);
            } else {
                $result = [
                    "status" => "error",
                    "message" => "Product could not be added!",
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

    public function updateProduct(Request $request, $cID)
    {
        $categories = categoryModel::where('status', 1)->get();
        $product = DB::table('t_products')->where('id', $cID)->first();
        $product->product_gallery = DB::table('t_product_gallery')
            ->where('product_id', $product->product_id)
            ->get()
            ->toArray();
        return view('product.updateProduct', ['product' => $product, 'categories' => $categories]);
    }

    public function deleteGalleryImage(Request $request, $gID)
    {
        $deleted = DB::table('t_product_gallery')->where('id', '=', $gID)->delete();

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
}
