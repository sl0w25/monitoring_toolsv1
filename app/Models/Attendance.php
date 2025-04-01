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
        'is_hired',
        'w_listed',
        'qr_number',
        'amount',
        'time_in',
        'image'

    ];

    public function location()
    {
        return $this->belongsTo(LocationInfo::class, 'id');
    }

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'qr_number', 'qr_number');
    }

}
