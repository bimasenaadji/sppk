<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            echo "Data not found in orders or services table.";
            return;
        }

        // Create multiple order items for each order
        $data = [
            [
                'order_id' => $orders[0],
                'service_id' => $services[0],
                'qty' => 1,
                'amount' => 100000.00,
                'total_amount' => 1 * 100000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => $orders[0],
                'service_id' => $services[1] ?? $services[0],
                'qty' => 2,
                'amount' => 75000.00,
                'total_amount' => 2 * 75000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => $orders[1],
                'service_id' => $services[0],
                'qty' => 3,
                'amount' => 50000.00,
                'total_amount' => 3 * 50000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => $orders[2],
                'service_id' => $services[2] ?? $services[0],
                'qty' => 4,
                'amount' => 25000.00,
                'total_amount' => 4 * 25000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => $orders[3],
                'service_id' => $services[1],
                'qty' => 5,
                'amount' => 90000.00,
                'total_amount' => 5 * 90000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => $orders[4],
                'service_id' => $services[2] ?? $services[1],
                'qty' => 2,
                'amount' => 110000.00,
                'total_amount' => 2 * 110000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('order_items')->insert($data);
    }
}
