<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_items')->insert([
            [
                'order_id' => 1,
                'service_id' => 1,
                'qty' => 2,
                'amount' => 100000.00,
                'total_amount' => 200000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 1,
                'service_id' => 2,
                'qty' => 1,
                'amount' => 150000.00,
                'total_amount' => 150000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2,
                'service_id' => 1,
                'qty' => 3,
                'amount' => 100000.00,
                'total_amount' => 300000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
