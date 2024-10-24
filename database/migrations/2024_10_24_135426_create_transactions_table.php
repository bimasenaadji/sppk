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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('tax_categories_id');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('ppn_amount', 10, 2);
            $table->decimal('pph_amount', 10, 2);
            $table->decimal('net_amount', 10, 2);
            $table->timestamps();

            // $table->foreign('order_id')->references('id')->on('orders');
            // $table->foreign('customer_id')->references('id')->on('customers');
            // $table->foreign('tax_categories_id')->references('id')->on('tax_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
