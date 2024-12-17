<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tax_categories')->insert([
            [
                'transaction_type' => 'Barang Umum',
                'tax_type' => 'PPN',
                'tax_ppn' => 11.00,
                'tax_pph' => 0.00,
                'description' => 'PPN untuk penjualan barang umum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Jasa Umum',
                'tax_type' => 'PPN',
                'tax_ppn' => 11.00,
                'tax_pph' => 0.00,
                'description' => 'PPN untuk jasa umum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Jasa Konsultasi',
                'tax_type' => 'PPN & PPh 23',
                'tax_ppn' => 11.00,
                'tax_pph' => 2.00,
                'description' => 'Jasa konsultasi dengan potongan PPh 23',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Barang Mewah',
                'tax_type' => 'PPNBM',
                'tax_ppn' => 20.00,
                'tax_pph' => 0.00,
                'description' => 'Pajak Penjualan Barang Mewah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Jasa Konstruksi',
                'tax_type' => 'PPN',
                'tax_ppn' => 11.00,
                'tax_pph' => 0.00,
                'description' => 'PPN untuk jasa konstruksi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Jasa Pendidikan',
                'tax_type' => 'Bebas PPN',
                'tax_ppn' => 0.00,
                'tax_pph' => 0.00,
                'description' => 'PPh Final Pasal 4 Ayat 2 dikenakan pada pendapatan bunga deposito atau tabungan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Jasa Transportasi',
                'tax_type' => 'Bebas PPN',
                'tax_ppn' => 0.00,
                'tax_pph' => 0.00,
                'description' => 'Layanan transportasi umum bebas PPN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
