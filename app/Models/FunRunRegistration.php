<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunRunRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'division',
        'section',
        'contact_number',
        'sex',
        'emergency_contact_name',
        'emergency_contact_number',
        'race_category',
        'health_consent_form',
        'qr_number',
        'dswd_id',
        'dswd_id_hash',
        'qr_number_hash',
    ];

    protected $casts = [
    'qr_number' => 'string',
];
}
