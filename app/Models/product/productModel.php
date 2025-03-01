<?php

namespace App\Models\product;

use Illuminate\Database\Eloquent\Model;

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
}
