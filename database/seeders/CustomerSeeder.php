<?php

namespace Database\Seeders;

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
                'name' => 'Syahrial Rizky',
                'email' => 'syahrialrizky04@gmail.com',
                'no_telp' => '081234567890',
                'alamat' => 'Jl. Gubeng Kertajaya No. 23, Surabaya',
                'tax_id' => null,
            ],
            // [
            //     'id' => 2,
            //     'name' => 'Jane Smith',
            //     'email' => 'jane.smith@example.com',
            //     'no_telp' => '082234567891',
            //     'alamat' => 'Jl. Melati No. 2, Bandung',
            //     'tax_id' => null,
            // ],
            // [
            //     'id' => 3,
            //     'name' => 'Michael Johnson',
            //     'email' => 'michael.j@example.com',
            //     'no_telp' => '083234567892',
            //     'alamat' => 'Jl. Tunjungan No. 3, Surabaya',
            //     'tax_id' => null,
            // ],
            // [
            //     'id' => 4,
            //     'name' => 'Alice Williams',
            //     'email' => 'alice.w@example.com',
            //     'no_telp' => '084234567893',
            //     'alamat' => 'Jl. Anggrek No. 4, Medan',
            //     'tax_id' => null,
            // ],
            // [
            //     'id' => 5,
            //     'name' => 'Robert Brown',
            //     'email' => 'robert.b@example.com',
            //     'no_telp' => '085234567894',
            //     'alamat' => 'Jl. Cempaka No. 5, Yogyakarta',
            //     'tax_id' => null,
            // ],
            // [
            //     'id' => 6,
            //     'name' => 'Emily Davis',
            //     'email' => 'emily.d@example.com',
            //     'no_telp' => '086234567895',
            //     'alamat' => 'Jl. Kenanga No. 6, Bali',
            //     'tax_id' => null,
            // ],
            // [
            //     'id' => 7,
            //     'name' => 'James Wilson',
            //     'email' => 'james.w@example.com',
            //     'no_telp' => '087234567896',
            //     'alamat' => 'Jl. Jati No. 7, Semarang',
            //     'tax_id' => null,
            // ],
            // [
            //     'id' => 8,
            //     'name' => 'Linda Moore',
            //     'email' => 'linda.m@example.com',
            //     'no_telp' => '088234567897',
            //     'alamat' => 'Jl. Melur No. 8, Surakarta',
            //     'tax_id' => null,
            // ],
            // [
            //     'id' => 9,
            //     'name' => 'David Taylor',
            //     'email' => 'david.t@example.com',
            //     'no_telp' => '089234567898',
            //     'alamat' => 'Jl. Flamboyan No. 9, Palembang',
            //     'tax_id' => null,
            // ],
            // [
            //     'id' => 10,
            //     'name' => 'Sophia Anderson',
            //     'email' => 'sophia.a@example.com',
            //     'no_telp' => '090234567899',
            //     'alamat' => 'Jl. Bunga No. 10, Batam',
            //     'tax_id' => null,
            // ],
            // [
            //     'id' => 11,
            //     'name' => 'William Anderson',
            //     'email' => 'william.a@example.com',
            //     'no_telp' => '089234567800',
            //     'alamat' => 'Jl. Flambo No. 95, Palembang',
            //     'tax_id' => null,
            // ],
            // [
            //     'id' => 12,
            //     'name' => 'Sophia Lawson',
            //     'email' => 'sophia.l@example.com',
            //     'no_telp' => '090234567880',
            //     'alamat' => 'Jl. Bunga Mawar No. 10, Batam',
            //     'tax_id' => null,
            // ]
        ]);
    }
}
