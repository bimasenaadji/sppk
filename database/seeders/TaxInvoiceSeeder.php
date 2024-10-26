<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tax_invoices')->insert([
            [
                'id' => 1,
                'invoice_id' => 1,
                'tax_invoice_number' => 1001,
                'ppn_amount' => 0.11,
                'pph_amount' => 0,
            ],
            [
                'id' => 2,
                'invoice_id' => 2,
                'tax_invoice_number' => 1002,
                'ppn_amount' => 0.11,
                'pph_amount' => 0,
            ],
            [
                'id' => 3,
                'invoice_id' => 3,
                'tax_invoice_number' => 1003,
                'ppn_amount' => 0,
                'pph_amount' => 0.11,
            ]


        ]);
    }
}
