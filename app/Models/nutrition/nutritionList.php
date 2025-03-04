<?php

namespace App\Models\nutrition;

use Illuminate\Database\Eloquent\Model;

class nutritionList extends Model
{
    protected $table = 't_nutrition_list';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
