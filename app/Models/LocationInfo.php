<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationInfo extends Model
{
    protected $fillable = ['region', 'province', 'municipality', 'district', 'barangay','ec'];

    public function familyHeads()
    {
        return $this->hasMany(FamilyHead::class, 'fam_id');
    }

    public function accountInfo()
    {
        return $this->hasMany(AccountInfo::class,  'fam_id');
    }

    public function assistance()
    {
        return $this->hasMany(Assistance::class,  'fam_id');
    }

    public function attendance()
    {
        return $this->hasMany(Assistance::class,  'fam_id');
    }

    public function locationInfo()
    {
        return $this->hasOne(LocationInfo::class, 'id', 'fam_id');
    }


}

