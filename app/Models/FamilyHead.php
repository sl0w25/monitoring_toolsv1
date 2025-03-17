<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyHead extends Model
{
    protected $fillable = [
                         'fam_id',
                         'province',
                         'municipality',
                         'barangay',
                         'last_name',
                         'first_name',
                         'middle_name',
                         'ext_name',
                         'birthday',
                         'age',
                         'gender',
                         'birthplace',
                         'civil_status',
                         'mothers_maiden',
                         'religion',
                         'occupation',
                         'net_income',
                         'id_card',
                         'id_number',
                         'contact',
                         'permanent_address',
                         '4ps',
                         'ips',
                         'others',
                         'qr_number',
                         'status',
                         'is_hired',
                         'validated_by'
                        ];

                        // public function location()
                        // {
                        //     return $this->belongsTo(LocationInfo::class, 'id');
                        // }
}

