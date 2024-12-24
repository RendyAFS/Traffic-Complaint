<?php

namespace Database\Seeders;

use App\Models\SetValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert only the context values (Waktu, Lokasi, People, Kondisi, Object)
        $contexts = ['Waktu', 'Lokasi', 'People', 'Kondisi', 'Object'];

        foreach ($contexts as $context) {
            SetValue::create([
                'konteks' => $context,
                'value' => json_encode((object)[]), // Initialize value as empty JSON object
            ]);
        }
    }
}
