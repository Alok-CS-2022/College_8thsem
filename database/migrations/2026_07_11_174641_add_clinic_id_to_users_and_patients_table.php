<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('clinic_id')->nullable()->after('role_id')->constrained()->nullOnDelete();
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('clinic_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('clinic_id');
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->dropConstrainedForeignId('clinic_id');
        });
    }
};
