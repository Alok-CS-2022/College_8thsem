<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MedicalCaseNote extends Model
{
    protected $fillable = ['medical_case_id', 'user_id', 'type', 'content'];

    public function medicalCase() { return $this->belongsTo(MedicalCase::class); }
    public function user() { return $this->belongsTo(User::class); }
}
