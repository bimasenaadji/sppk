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
                'transaction_type' => 'Penjualan Barang',
                'tax_type' => 'PPN',
                'tax_ppn' => 11.00,
                'tax_pph' => 0.00,
                'description' => 'Pajak Pertambahan Nilai (PPN) dikenakan untuk penjualan barang di dalam negeri.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Penjualan Jasa',
                'tax_type' => 'PPN & PPh 23',
                'tax_ppn' => 11.00,
                'tax_pph' => 2.00,
                'description' => 'PPN dan Pajak Penghasilan (PPh) Pasal 23 dikenakan untuk penjualan jasa di dalam negeri.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Jasa Konsultan',
                'tax_type' => 'PPN & PPh 21',
                'tax_ppn' => 11.00,
                'tax_pph' => 5.00,
                'description' => 'PPN dan PPh Pasal 21 dikenakan pada jasa profesional, seperti konsultan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Sewa Tanah/Bangunan',
                'tax_type' => 'PPN & PPh 4 Ayat 2',
                'tax_ppn' => 11.00,
                'tax_pph' => 10.00,
                'description' => 'PPN dan PPh Final Pasal 4 Ayat 2 dikenakan untuk pendapatan dari sewa tanah atau bangunan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Dividen',
                'tax_type' => 'PPh 4 Ayat 2',
                'tax_ppn' => 0.00,
                'tax_pph' => 10.00,
                'description' => 'PPh Final Pasal 4 Ayat 2 dikenakan pada pendapatan dividen.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Bunga Deposito/Tabungan',
                'tax_type' => 'PPh 4 Ayat 2',
                'tax_ppn' => 0.00,
                'tax_pph' => 20.00,
                'description' => 'PPh Final Pasal 4 Ayat 2 dikenakan pada pendapatan bunga deposito atau tabungan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'Hadiah Undian',
                'tax_type' => 'PPh 4 Ayat 2',
                'tax_ppn' => 0.00,
                'tax_pph' => 25.00,
                'description' => 'PPh Final Pasal 4 Ayat 2 dikenakan pada hadiah undian.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
