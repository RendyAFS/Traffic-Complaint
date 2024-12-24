<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $type_complaints = ['tidak urgent', 'kurang urgent', 'urgent', 'sangat urgent'];
        $text_complaints = [
            "Aduan kemacetan di jalan Sudirman, Jakarta",
            "Banjir di jalan Ahmad Yani, Surabaya",
            "Pohon tumbang di jalan Merdeka, Bandung",
            "Kecelakaan lalu lintas di jalan Pemuda, Semarang",
            "Kemacetan di jalan Diponegoro, Yogyakarta",
            "Banjir parah di jalan Gatot Subroto, Jakarta",
            "Jalanan licin karena hujan di jalan Imam Bonjol, Denpasar",
            "Kecelakaan di jalan Jenderal Sudirman, Jakarta",
            "Aduan pohon tumbang di jalan MH Thamrin, Medan",
            "Macet panjang di jalan Gajah Mada, Solo",
            "Banjir melanda jalan Ahmad Yani, Surabaya",
            "Kecelakaan di jalan Ahmad Dahlan, Malang",
            "Macet di jalan Sultan Agung, Bekasi",
            "Pohon tumbang akibat angin di jalan Diponegoro, Bogor",
            "Aduan banjir di jalan HOS Cokroaminoto, Tangerang",
            "Kecelakaan motor di jalan Dr. Sutomo, Samarinda",
            "Macet di jalan Pahlawan, Surabaya",
            "Banjir di jalan Proklamasi, Jakarta",
            "Kecelakaan mobil di jalan Juanda, Jakarta",
            "Aduan pohon tumbang di jalan Kartini, Bali",
        ];

        $data = [];
        $now = Carbon::now();

        for ($i = 1; $i <= 6; $i++) {
            $text_complaint = $text_complaints[array_rand($text_complaints)];

            // Extract location from text_complaint
            $location = str_contains($text_complaint, 'di jalan')
                ? explode(", ", trim(explode('di jalan', $text_complaint)[1]))[0]
                : 'lokasi tidak disebutkan';

            // Extract category_complaint: main issue and location only
            preg_match('/(Aduan|Kecelakaan|Banjir|Pohon|Macet|Kemacetan)[^\s]*/i', $text_complaint, $matches);
            $issue = strtolower($matches[0] ?? 'kendala');

            $category_complaint = $issue . ', ' . strtolower($location);

            // Generate created_at and updated_at
            $created_at = $now->copy()->subDays(rand(1, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $updated_at = $created_at->copy()->addDays(rand(1, 3));

            $data[] = [
                'users_id' => rand(1, 3),
                'text_complaint' => $text_complaint,
                'type_complaint' => $type_complaints[array_rand($type_complaints)],
                'category_complaint' => $category_complaint,
                'status' => 'Aduan Masuk',
                'lokasi' => $location,
                'gambar' => null, // Assuming no image for now
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
        }

        // Insert the data into the complaints table
        DB::table('complaints')->insert($data);
    }
}
