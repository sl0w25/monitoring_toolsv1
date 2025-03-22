<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $fillable = [
       'bene_id',
       'last_name',
       'first_name',
       'middle_name',
       'ext_name',
       'birth_month',
       'birth_day',
       'birth_year',
       'sex',
       'barangay',
       'psgc_city',
       'municipality',
       'province',
       'type_of_assistance',
       'amount',
       'philsys_number',
       'beneficiary_unique_id',
       'contact_number',
       'target_sector',
       'sub_category',
       'civil_status',
       'qr_number',
       'is_hired',
       'w_listed',
       'ml_user',
       'validated_by'
       ];


}
