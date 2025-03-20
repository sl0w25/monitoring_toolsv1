<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'region',
        'province',
        'municipality',
        'barangay',
        'psgc',
        'email',
        'contact',
        'password',
        'is_admin',
        'is_approved',
        'is_province',
        'is_lgu',
        'swad_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_approved' => 'boolean',
            'is_province' => 'boolean',
            'is_lgu' => 'boolean',
            'swad_admin' => 'boolean'
        ];
    }

    public function isAdmin(): bool
    {
        return $this->email =='faced@dswd.gov.ph';
    }

    public function isApproved(): bool
    {
        return $this->approved =='1';
    }

    public function isSwadAdmin(): bool
    {
        return $this->swad_admin =='1';
    }

    public function beneficiaries()
    {
        return $this->hasMany([Beneficiary::class => 'validated_by']);
    }
}
