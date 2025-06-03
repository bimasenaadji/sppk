<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique(); // No. Laporan
            $table->date('incident_date'); // Tanggal Kejadian
            $table->string('incident_area');
            $table->string('incident_type');
            $table->string('victim');
            $table->foreignId('reporter_id')->constrained('users');
            $table->enum('status', ['baru', 'proses', 'selesai'])->default('baru');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
