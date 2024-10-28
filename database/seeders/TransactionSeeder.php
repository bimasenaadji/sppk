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
        // Ambil semua data dari tabel orders
        $orders = DB::table('orders')->get();


        foreach ($orders as $order) {
            $totalAmount = $order->total * 1000;
            $ppnAmount = $totalAmount * 0.11;
            $pphAmount = $totalAmount * 0.02;
            $netAmount = $totalAmount + $ppnAmount - $pphAmount;

            DB::table('transactions')->insert([
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'tax_categories_id' => 1,
                'total_amount' => $totalAmount,
                'ppn_amount' => $ppnAmount,
                'pph_amount' => $pphAmount,
                'net_amount' => $netAmount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
