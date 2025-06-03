<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $report = Report::where('report_number', 'RPT-0001')->first();
        $uploader = User::where('email', 'pelapor1@example.com')->first();

        Image::create([
            'report_id' => $report->id,
            'uploaded_by' => $uploader->id,
            'context' => 'report',
            'image_path' => 'reports/images/sample1.jpg', // pastikan filenya ada di storage/public/reports/images/
            'only_for_print' => true,
        ]);
    }
}
