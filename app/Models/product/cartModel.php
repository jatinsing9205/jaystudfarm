<?php

namespace App\Models\product;

use Illuminate\Database\Eloquent\Model;

class cartModel extends Model
{
    protected $table = 't_cart';
    public $timestamps = true;
    protected $fillable = [
        'username',
        'product_id',
        'quantity',
    ];
    protected $dates = [
        'updated_at',
        'created_at',
    ];
}
