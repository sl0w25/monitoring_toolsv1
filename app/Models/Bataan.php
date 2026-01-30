<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bataan extends Model
{
    protected $fillable = [
        'municipality',
        'unpaid',
        'paid',
        'w_listed',
        'bene',
    ];
}
