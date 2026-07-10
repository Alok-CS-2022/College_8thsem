<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        "user_id", "passport_number", "full_name", "date_of_birth",
        "gender", "address", "phone", "destination_country", "manpower_agency",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
