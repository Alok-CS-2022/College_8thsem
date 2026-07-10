<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        "patient_id", "appointment_id", "cbc", "hbsag", "vdrl", "hiv",
        "blood_group", "urine_test", "xray_findings", "status", "flagged_abnormal",
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
