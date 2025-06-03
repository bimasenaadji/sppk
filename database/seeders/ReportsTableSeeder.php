<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reporter = User::where('email', 'pelapor1@example.com')->first();

        if (!$reporter) {
            // Buat dummy user jika tidak ditemukan
            $reporter = User::create([
                'name' => 'Pelapor 1',
                'email' => 'pelapor1@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        Report::create([
            'report_number'   => 'RPT-0001',
            'incident_date'   => Carbon::parse('2025-05-20'),
            'incident_area'   => 'Warehouse A',
            'incident_type'   => 'Slip and Fall',
            'victim'          => 'John Doe',
            'reporter_id'     => $reporter->id,
            'status'          => 'baru',
        ]);
    }
}
