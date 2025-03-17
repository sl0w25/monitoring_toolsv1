<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pampanga extends Model
{
    protected $fillable = [
        'municipality',
        'paid',
        'unpaid',
        'bene',
    ];
}
