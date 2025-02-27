<?php

namespace App\Models\category;

use Illuminate\Database\Eloquent\Model;

class categoryModel extends Model
{
    protected $table = 't_category';
    public $timestamps = true;
    protected $fillable = [
        'category_name',
        'parent_id',
        'status'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
