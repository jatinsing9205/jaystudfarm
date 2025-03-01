<?php

namespace App\Models\product;

use Illuminate\Database\Eloquent\Model;

class productGalleryModel extends Model
{
    protected $table = 't_product_gallery';
    public $timestamps = true;
    protected $fillable = [
        'product_id',
        'file_path',
        'created_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
