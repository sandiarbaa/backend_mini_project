<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\ItemPenjualan;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil beberapa pelanggan & barang
        $pelanggans = Pelanggan::all();
        $barangs = Barang::all();

        if ($pelanggans->isEmpty() || $barangs->isEmpty()) {
            $this->command->info("Seeder gagal: Pastikan pelanggan dan barang sudah ada.");
            return;
        }

        DB::beginTransaction();

        try {
            // Buat 5 transaksi penjualan dummy
            for ($i = 1; $i <= 5; $i++) {
                $pelanggan = $pelanggans->random();
                $tgl = Carbon::now()->subDays(rand(0, 10))->toDateString();

                $penjualan = Penjualan::create([
                    'tgl' => $tgl,
                    'pelanggan_id' => $pelanggan->id,
                    'subtotal' => 0,
                ]);

                $subtotal = 0;

                // Pilih 1-3 barang random untuk transaksi
                $itemBarang = $barangs->random(rand(1, 3));

                foreach ($itemBarang as $barang) {
                    $qty = rand(1, 5);
                    $lineSubtotal = $barang->harga * $qty;
                    $subtotal += $lineSubtotal;

                    ItemPenjualan::create([
                        'penjualan_id' => $penjualan->id,
                        'barang_id' => $barang->id,
                        'qty' => $qty,
                    ]);
                }

                // Update subtotal
                $penjualan->update(['subtotal' => $subtotal]);
            }

            DB::commit();
            $this->command->info("Seeder Penjualan berhasil dijalankan!");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Seeder Penjualan gagal: " . $e->getMessage());
        }
    }
}
