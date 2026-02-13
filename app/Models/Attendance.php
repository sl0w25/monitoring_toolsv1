<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'dswd_id',
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'division',
        'section',
        'sex',
        'status',
        'qr_number',
        'time_in',
        'race_category',
        'image',

    ];


    public function beneficiary()
    {
        return $this->belongsTo(FunRunRegistration::class, 'qr_number', 'qr_number');
    }

}


