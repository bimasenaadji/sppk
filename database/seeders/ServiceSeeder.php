<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'service' => 'Web Development',
                'tax_categories_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service' => 'Graphic Design',
                'tax_categories_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service' => 'Digital Marketing',
                'tax_categories_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Anda dapat menambahkan lebih banyak data di sini jika diperlukan
        ]);
    }
}
