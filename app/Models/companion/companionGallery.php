<?php

namespace App\Models\companion;

use Illuminate\Database\Eloquent\Model;

class companionGallery extends Model
{
    protected $table = 't_companion_gallery';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'type',
        'file_path',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
