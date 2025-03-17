<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    protected $fillable = [
        'fam_id',
        'date',
        'name_receiver',
        'disaster',
        'assistance',
        'unit',
        'quantity',
        'cost',
        'provider',
        'status'
    ];



    public function location()
    {
        return $this->belongsTo(LocationInfo::class, 'id');
    }



}
