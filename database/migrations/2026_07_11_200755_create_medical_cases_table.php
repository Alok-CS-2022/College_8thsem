<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->enum('status', [
                'created', 'registration_complete', 'tests_pending', 'testing_in_progress',
                'results_available', 'doctor_review_pending', 'approved', 'rejected', 'certificate_generated',
            ])->default('created');
            $table->foreignId('assigned_doctor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_lab_tech_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('identity_verified')->default(false);
            $table->boolean('physical_exam_done')->default(false);
            $table->boolean('blood_test_done')->default(false);
            $table->boolean('xray_done')->default(false);
            $table->boolean('doctor_reviewed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_cases');
    }
};
