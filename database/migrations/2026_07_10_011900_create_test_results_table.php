<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('cbc')->nullable();
            $table->string('hbsag')->nullable();
            $table->string('vdrl')->nullable();
            $table->string('hiv')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('urine_test')->nullable();
            $table->string('xray_findings')->nullable();
            $table->enum('status', ['pending', 'lab_complete', 'xray_complete', 'ready_for_review', 'reviewed'])->default('pending');
            $table->boolean('flagged_abnormal')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
