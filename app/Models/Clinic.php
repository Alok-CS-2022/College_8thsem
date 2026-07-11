<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $fillable = [
        'name',
        'registration_number',
        'address',
        'contact_number',
        'email',
        'license_number',
        'license_expiry_date',
        'contact_person_name',
        'contact_person_position',
        'status',
    ];

    protected $casts = [
        'license_expiry_date' => 'date',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
