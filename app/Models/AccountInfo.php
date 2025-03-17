<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountInfo extends Model
{
    protected $fillable = [
                            'fam_id',
                            'bank',
                            'account_name',
                            'account_type',
                            'account_number',
                            'house_ownership',
                            'shelter',
                        ];

                        public function location()
                        {
                            return $this->belongsTo(LocationInfo::class, 'id');
                        }

}
