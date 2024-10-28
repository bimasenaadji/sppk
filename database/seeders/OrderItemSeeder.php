<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $orders = DB::table('orders')->pluck('id')->toArray();


        $services = DB::table('services')->pluck('id')->toArray();


        if (empty($orders) || empty($services)) {
            echo "Data tidak ditemukan di tabel orders atau services.";
            return;
        }


        DB::table('order_items')->insert([
            [
                'order_id' => $orders[0],
                'service_id' => $services[0],
                'qty' => 2,
                'amount' => 100000.00,
                'total_amount' => 2 * 100000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => $orders[0],
                'service_id' => $services[1] ?? $services[0],
                'qty' => 1,
                'amount' => 150000.00,
                'total_amount' => 1 * 150000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => $orders[1] ?? $orders[0],
                'service_id' => $services[0],
                'qty' => 3,
                'amount' => 100000.00,
                'total_amount' => 3 * 100000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
