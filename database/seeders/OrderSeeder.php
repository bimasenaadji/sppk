<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'customer_id' => 1,
                'date' => '2024-10-27',
                'total' => 500,
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 2,
                'date' => '2024-10-28',
                'total' => 300,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 3,
                'date' => '2024-10-28',
                'total' => 700,
                'status' => 'canceled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 4,
                'date' => '2024-10-29',
                'total' => 450,
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 5,
                'date' => '2024-10-30',
                'total' => 650,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 6,
                'date' => '2024-10-31',
                'total' => 200,
                'status' => 'canceled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 7,
                'date' => '2024-11-01',
                'total' => 800,
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 8,
                'date' => '2024-11-02',
                'total' => 300,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 9,
                'date' => '2024-11-03',
                'total' => 500,
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 10,
                'date' => '2024-11-04',
                'total' => 700,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 11,
                'date' => '2024-11-04',
                'total' => 800,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 12,
                'date' => '2024-11-04',
                'total' => 816,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
