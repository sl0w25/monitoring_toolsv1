<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nueva extends Model
{
    protected $fillable = [
        'municipality',
        'present',
        'absent',
        'is_hired',
        'w_listed',
        'bene',
    ];
}
