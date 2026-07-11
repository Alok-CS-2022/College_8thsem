<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        "patient_id", "test_result_id", "doctor_id", "status",
        "issue_date", "expiry_date", "pdf_path",
    ];

    protected $casts = [
        "issue_date" => "date",
        "expiry_date" => "date",
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function testResult()
    {
        return $this->belongsTo(TestResult::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, "doctor_id");
    }
}
