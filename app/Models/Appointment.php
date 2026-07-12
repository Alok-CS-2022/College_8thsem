<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        "patient_id", "appointment_date", "appointment_time", "queue_token", "status",
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function testResult()
    {
        return $this->hasOne(TestResult::class);
    }

    public function medicalCase()
    {
        return $this->hasOne(MedicalCase::class);
    }
}
