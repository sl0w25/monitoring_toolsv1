<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyInfo extends Model
{
    protected $fillable = ['fam_id', 'last_name', 'first_name', 'middle_name', 'ext_name','relation','birthday','age','gender','educational_attainment','occupation','vulnerability_type'];
}
