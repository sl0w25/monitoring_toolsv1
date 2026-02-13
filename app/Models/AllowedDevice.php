<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllowedDevice extends Model
{
   protected $fillable = [
        'device_name',
        'device_token',
        'active'
    ];
}
