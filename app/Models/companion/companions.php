<?php

namespace App\Models\companion;

use DB;
use Illuminate\Database\Eloquent\Model;

class companions extends Model
{
    protected $table = 't_companions';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'name',
        'dob',
        'height',
        'sex',
        'category',
        'type',
        'source',
        'purchase_date',
        'purchase_amount',
        'short_description',
        'description',
        'image',
        'micro_chip_number',
        'status',
        'created_by',
        'updated_by',
    ];
    // protected $dates = [
    //     'created_at',
    //     'updated_at',
    // ];

    public function companionDetails($cID)
    {
        $companion = DB::table('t_companions')
            ->leftJoin('t_category as c', 't_companions.category', '=', 'c.id')
            ->select("t_companions.*", "c.category_name")
            ->where([
                't_companions.companion_id' => $cID
            ])
            ->get();

        foreach ($companion as $com) {
            $com->gallery_images = DB::table('t_companion_gallery')
                ->where([
                    'companion_id' => $com->companion_id,
                    'status' => 1
                ])
                ->get()
                ->toArray();
        }
        foreach ($companion as $product) {
            $com->dam_sire_info = DB::table('t_companion_dam_sire')
                ->where([
                    'companion_id' => $com->companion_id,
                    'status' => 1
                ])
                ->get()
                ->toArray();
        }
        return $companion;
    }
}
