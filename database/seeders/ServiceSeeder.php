<?php

namespace Database\Seeders;

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
            [
                'service' => 'SEO Optimization',
                'tax_categories_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service' => 'Content Writing',
                'tax_categories_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service' => 'Social Media Management',
                'tax_categories_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service' => 'Mobile App Development',
                'tax_categories_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service' => 'Email Marketing',
                'tax_categories_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service' => 'Video Production',
                'tax_categories_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service' => 'IT Consulting',
                'tax_categories_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service' => '3D Animation',
                'tax_categories_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service' => 'Logo Design',
                'tax_categories_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
