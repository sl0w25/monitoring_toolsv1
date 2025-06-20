<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nueva extends Model
{
    protected $fillable = [
        'municipality',
        'unpaid',
        'paid',
        'w_listed',
        'bene',
    ];
}
