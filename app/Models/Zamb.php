<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zamb extends Model
{
    protected $fillable = [
        'municipality',
        'present',
        'absent',
        'is_hired',
        'bene',
    ];
}
