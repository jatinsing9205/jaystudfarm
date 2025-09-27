<?php

namespace App\Models\category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class categoryModel extends Model
{
    protected $table = 't_category';
    public $timestamps = true;
    protected $fillable = [
        'category_name',
        'parent_id',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function countCategory()
    {
        return DB::table('t_category')
            ->where('status', 1)
            ->count();
    }
}
