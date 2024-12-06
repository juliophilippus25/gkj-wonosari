<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WilayahTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data wilayah
        $dataWilayah = [
            'Wilayah 1',
            'Wilayah 2',
            'Wilayah 3',
            'Wilayah 4',
            'Wilayah 5',
            'Wilayah 6',
            'Wilayah 7',
            'Wilayah 8',
            'Wilayah 9',
            'Panthan Bendungan',
            'Panthan Randukuning',
            'Panthan Nglipar',
            'Panthan Kebonjero',
            'Panthan Hargomulyo',
            'Kelompok Wareng',
        ];

        foreach ($dataWilayah as $nama) {
            $id = strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s') . uniqid()));

            // Insert data wilayah ke dalam tabel
            Wilayah::create([
                'id' => $id,
                'nama' => $nama,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
