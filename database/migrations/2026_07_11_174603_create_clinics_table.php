<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('registration_number')->unique();
            $table->string('address');
            $table->string('contact_number');
            $table->string('email');
            $table->string('license_number');
            $table->date('license_expiry_date');
            $table->string('contact_person_name');
            $table->string('contact_person_position');
            $table->enum('status', ['submitted', 'under_review', 'approved', 'active', 'suspended', 'revoked'])
                  ->default('submitted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
