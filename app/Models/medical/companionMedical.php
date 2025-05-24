<?php

namespace App\Models\medical;

use Illuminate\Database\Eloquent\Model;

class companionMedical extends Model
{
    protected $table = 't_companion_medical';
    public $timestamps = true;
    protected $fillable = [
        'companion_id',
        'treated_for',
        'date',
        'medication_given',
        'next_followup_date',
        'next_followup_status',
        'next_followup_remark',
        'doctor_remark',
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
