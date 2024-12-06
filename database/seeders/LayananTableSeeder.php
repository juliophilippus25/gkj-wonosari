<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data layanan
        $dataLayanan = [
            'Baptis',
            'Sidhi/Baptis Dewasa',
            'Katekisasi',
        ];

        foreach ($dataLayanan as $nama) {
            $id = strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s') . uniqid()));

            // Insert data wilayah ke dalam tabel
            Layanan::create([
                'id' => $id,
                'nama' => $nama,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
