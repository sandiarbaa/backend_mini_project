<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama'          => 'Budi Santoso',
                'domisili'      => 'JAK-UT',
                'jenis_kelamin' => 'PRIA',
            ],
            [
                'nama'          => 'Siti Aminah',
                'domisili'      => 'JAK-SEL',
                'jenis_kelamin' => 'WANITA',
            ],
            [
                'nama'          => 'Topa Wijaya',
                'domisili'      => 'JAK-BAR',
                'jenis_kelamin' => 'PRIA',
            ],
            [
                'nama'          => 'Dewi Lestari',
                'domisili'      => 'JAK-TIM',
                'jenis_kelamin' => 'WANITA',
            ],
        ];

        foreach ($data as $item) {
            Pelanggan::create($item);
        }
    }
}
