<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulacan extends Model
{
    protected $fillable = [
        'municipality',
        'paid',
        'unpaid',
        'bene',
    ];
}
