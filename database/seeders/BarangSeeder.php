<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama'     => 'Buku',
                'kategori' => 'ATK',
                'harga'    => 8000,
            ],
            [
                'nama'     => 'Pensil',
                'kategori' => 'ATK',
                'harga'    => 2000,
            ],
            [
                'nama'     => 'Kompor Gas',
                'kategori' => 'MASAK',
                'harga'    => 350000,
            ],
            [
                'nama'     => 'Sapu',
                'kategori' => 'RT',
                'harga'    => 15000,
            ],
            [
                'nama'     => 'Rice Cooker',
                'kategori' => 'ELEKTRONIK',
                'harga'    => 450000,
            ],
        ];

        foreach ($data as $item) {
            Barang::create($item);
        }
    }
}
