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
        $invoices = DB::table('invoices')->get();

        foreach ($invoices as $i) {
            DB::table('tax_invoices')->insert([
                'invoice_id' => $i->id,
                'tax_invoice_number' => 1002,
                'ppn_amount' => 0.11,
                'pph_amount' => 0,
            ]);
        }
    }
}
