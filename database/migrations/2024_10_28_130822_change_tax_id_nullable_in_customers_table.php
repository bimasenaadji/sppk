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
        Schema::table('customers', function (Blueprint $table) {

            $table->dropForeign(['tax_id']);


            $table->unsignedBigInteger('tax_id')->nullable()->change();


            $table->foreign('tax_id')->references('id')->on('tax_invoices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {

            $table->dropForeign(['tax_id']);

            // Ubah kembali tipe data ke string dan non-nullable
            $table->string('tax_id')->nullable(false)->change();


            $table->foreign('tax_id')->references('id')->on('tax_invoices');
        });
    }
};
