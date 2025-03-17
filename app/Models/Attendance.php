<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'bene_id',
        'province',
        'municipality',
        'barangay',
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'sex',
        'status',
        'qr_number',
        'amount',
        'time_in'
    ];

    public function location()
    {
        return $this->belongsTo(LocationInfo::class, 'id');
    }
}
