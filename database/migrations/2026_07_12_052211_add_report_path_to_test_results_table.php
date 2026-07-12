<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->string('report_path')->nullable()->after('xray_findings');
            $table->timestamp('report_uploaded_at')->nullable()->after('report_path');
            $table->foreignId('report_uploaded_by')->nullable()->after('report_uploaded_at')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropForeign(['report_uploaded_by']);
            $table->dropColumn(['report_path', 'report_uploaded_at', 'report_uploaded_by']);
        });
    }
};
