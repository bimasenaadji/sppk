<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = DB::table('transactions')->get();

        foreach ($transactions as $t) {
            DB::table('invoices')->insert([
                'transaction_id' => $t->id,
                'invoice_number' => 1001,
                'invoice_date' => now(),
                'due_date' => now(),
                'total_amount' => 2500000.00,
            ]);
        }
    }
}
