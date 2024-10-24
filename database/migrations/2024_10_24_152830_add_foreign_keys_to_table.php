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
            $table->foreign('tax_id')->references('id')->on('tax_invoices');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('transaction_id')->references('id')->on('transactions');
        });
        Schema::table('tax_invoices', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('invoices');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('service_id')->references('id')->on('services');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('tax_categories_id')->references('id')->on('tax_categories');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->foreign('tax_categories_id')->references('id')->on('tax_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table', function (Blueprint $table) {
            //
        });
    }
};
