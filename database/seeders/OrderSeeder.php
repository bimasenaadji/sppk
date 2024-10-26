<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ]);
    }
}
