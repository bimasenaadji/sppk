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
        DB::table('invoices')->insert([
            [
                'id' => 1,
                'transaction_id' => 1,
                'invoice_number' => 1001,
                'invoice_date' => now(),
                'due_date' => now(),
            ],
            [
                'id' => 2,
                'transaction_id' => 2,
                'invoice_number' => 1002,
                'invoice_date' => now(),
                'due_date' => now(),
            ],
            [
                'id' => 3,
                'transaction_id' => 3,
                'invoice_number' => 1003,
                'invoice_date' => now(),
                'due_date' => now(),
            ],
        ]);
    }
}
