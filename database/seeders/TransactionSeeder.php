<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transactions')->insert([
            [
                'order_id' => 1,
                'customer_id' => 1,
                'tax_categories_id' => 1, // Penjualan Barang
                'total_amount' => 500000.00,
                'ppn_amount' => 50000.00, // 11% dari total_amount
                'pph_amount' => 0.00,
                'net_amount' => 500000.00 + 50000.00, // total + ppn
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2,
                'customer_id' => 2,
                'tax_categories_id' => 2, // Penjualan Jasa
                'total_amount' => 750000.00,
                'ppn_amount' => 82500.00, // 11% dari total_amount
                'pph_amount' => 15000.00, // 2% dari total_amount
                'net_amount' => 750000.00 + 82500.00 - 15000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 3,
                'customer_id' => 3,
                'tax_categories_id' => 3, // Jasa Konsultan
                'total_amount' => 600000.00,
                'ppn_amount' => 66000.00, // 11% dari total_amount
                'pph_amount' => 30000.00, // 5% dari total_amount
                'net_amount' => 600000.00 + 66000.00 - 30000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 4,
                'customer_id' => 1,
                'tax_categories_id' => 4, // Sewa Tanah/Bangunan
                'total_amount' => 800000.00,
                'ppn_amount' => 88000.00, // 11% dari total_amount
                'pph_amount' => 80000.00, // 10% dari total_amount
                'net_amount' => 800000.00 + 88000.00 - 80000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 5,
                'customer_id' => 2,
                'tax_categories_id' => 5, // Dividen
                'total_amount' => 900000.00,
                'ppn_amount' => 0.00,
                'pph_amount' => 90000.00, // 10% dari total_amount
                'net_amount' => 900000.00 - 90000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
