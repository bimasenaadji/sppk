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
         Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->foreignId('inspected_by')->constrained('users');
            $table->string('severity_level');
            $table->foreignId('responsible_person_id')->nullable()->constrained('users');
            $table->text('corrective_action')->nullable();
            $table->text('preventive_action')->nullable();
            $table->timestamp('inspected_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
