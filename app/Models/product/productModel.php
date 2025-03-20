<?php

namespace App\Models\product;

use DB;
use Illuminate\Database\Eloquent\Model;
use function Laravel\Prompts\select;

class productModel extends Model
{
    protected $table = 't_products';
    public $timestamps = true;
    protected $fillable = [
        'product_id',
        'product_title',
        'product_category',
        'product_price',
        'product_sale_price',
        'product_short_description',
        'product_description',
        'product_image',
        'status',
        'created_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function allProducts()
    {
        $products = DB::table('t_products')
            ->leftJoin('t_category as c', 't_products.product_category', '=', 'c.id')
            ->select("t_products.*", "c.category_name")
            ->where('t_products.status', 1)
            ->get();

        foreach ($products as $product) {
            $product->product_gallery = DB::table('t_product_gallery')
                ->select("file_path")
                ->where('product_id', $product->product_id)
                ->get()
                ->toArray();
        }

        return $products;
    }
    public function productDetails($pId)
    {
        $products = DB::table('t_products')
            ->leftJoin('t_category as c', 't_products.product_category', '=', 'c.id')
            ->select("t_products.*", "c.category_name")
            ->where([
                't_products.status' => 1,
                't_products.product_id' => $pId
            ])
            ->get();

        foreach ($products as $product) {
            $product->product_gallery = DB::table('t_product_gallery')
                ->select("file_path")
                ->where('product_id', $product->product_id)
                ->get()
                ->toArray();
        }

        return $products;
    }
}
