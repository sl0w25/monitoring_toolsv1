<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarlac extends Model
{
    protected $fillable = [
        'municipality',
        'present',
        'absent',
        'is_hired',
        'bene',
    ];
}
