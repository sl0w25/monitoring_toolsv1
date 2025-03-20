<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aurora extends Model
{
    use HasFactory;

    protected $fillable = [
        'municipality',
        'present',
        'absent',
        'is_hired',
        'bene',
    ];
}
