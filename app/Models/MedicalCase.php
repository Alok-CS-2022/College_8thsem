<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MedicalCase extends Model
{
    protected $fillable = [
        'appointment_id', 'patient_id', 'status',
        'assigned_doctor_id', 'assigned_lab_tech_id',
        'identity_verified', 'physical_exam_done', 'blood_test_done', 'xray_done', 'doctor_reviewed',
    ];

    protected $casts = [
        'identity_verified' => 'boolean',
        'physical_exam_done' => 'boolean',
        'blood_test_done' => 'boolean',
        'xray_done' => 'boolean',
        'doctor_reviewed' => 'boolean',
    ];

    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(User::class, 'assigned_doctor_id'); }
    public function labTech() { return $this->belongsTo(User::class, 'assigned_lab_tech_id'); }
    public function notes() { return $this->hasMany(MedicalCaseNote::class); }

    public function isReadyForCertificate(): bool
    {
        return $this->identity_verified
            && $this->physical_exam_done
            && $this->blood_test_done
            && $this->xray_done
            && $this->doctor_reviewed;
    }
}
