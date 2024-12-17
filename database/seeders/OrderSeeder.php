<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Periksa apakah sudah ada data di tabel orders
        if (DB::table('orders')->count() === 0) {
            // Jika belum ada data, maka masukkan data awal
            DB::table('orders')->insert([
                [
                    'customer_id' => 1,
                    'date' => '2024-10-27',
                    'total' => null,
                    'status' => 'pending',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'customer_id' => 1,
                    'date' => '2024-10-28',
                    'total' => null,
                    'status' => 'pending',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'customer_id' => 1,
                    'date' => '2024-10-29',
                    'total' => null,
                    'status' => 'pending',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'customer_id' => 1,
                    'date' => '2024-10-30',
                    'total' => null,
                    'status' => 'pending',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'customer_id' => 1,
                    'date' => '2024-11-01',
                    'total' => null,
                    'status' => 'pending',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);
        }

        // Ambil semua order untuk diperbarui totalnya
        $orders = DB::table('orders')->get();

        foreach ($orders as $order) {
            // Jika total masih 0 atau null, hitung ulang berdasarkan order_items
            if (!$order->total || $order->total == 0) {
                $totalAmount = DB::table('order_items')
                    ->where('order_id', $order->id)
                    ->sum('total_amount');

                // Update total di tabel orders jika ditemukan total_amount
                if ($totalAmount > 0) {
                    DB::table('orders')
                        ->where('id', $order->id)
                        ->update(['total' => $totalAmount]);
                }
            }
        }
    }
}
