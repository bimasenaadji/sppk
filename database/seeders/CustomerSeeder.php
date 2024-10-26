<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'no_telp' => '081234567890',
                'alamat' => 'Jl. Mawar No. 1, Jakarta',
                'tax_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'no_telp' => '082234567891',
                'alamat' => 'Jl. Melati No. 2, Bandung',
                'tax_id' => 2,
            ],
            [
                'id' => 3,
                'name' => 'Michael Johnson',
                'email' => 'michael.j@example.com',
                'no_telp' => '083234567892',
                'alamat' => 'Jl. Tunjungan No. 3, Surabaya',
                'tax_id' => 3,
            ],
            // Anda bisa menambahkan lebih banyak data di sini
        ]);
    }
}
