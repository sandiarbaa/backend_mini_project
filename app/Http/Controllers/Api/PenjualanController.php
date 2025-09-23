<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Penjualan::with(['pelanggan', 'itemPenjualans.barang'])->get();

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Berhasil mengambil semua data penjualan',
                'data'       => $data,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Terjadi kesalahan saat mengambil data penjualan',
                'error'      => $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tgl' => 'required|date',
                'pelanggan_id' => 'required|exists:pelanggans,id',
                'items' => 'required|array|min:1',
                'items.*.barang_id' => 'required|exists:barangs,id',
                'items.*.qty' => 'required|integer|min:1',
            ]);

            DB::beginTransaction();

            $penjualan = Penjualan::create([
                'tgl' => $validated['tgl'],
                'pelanggan_id' => $validated['pelanggan_id'],
                'subtotal' => 0,
            ]);

            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                $lineSubtotal = $barang->harga * $item['qty'];
                $subtotal += $lineSubtotal;

                ItemPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $barang->id,
                    'qty' => $item['qty'],
                ]);
            }

            $penjualan->update(['subtotal' => $subtotal]);

            DB::commit();

            return response()->json([
                'statusCode' => 201,
                'status'     => 'success',
                'message'    => 'Penjualan berhasil ditambahkan',
                'data'       => $penjualan->load(['pelanggan', 'itemPenjualans.barang']),
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Gagal menambahkan penjualan',
                'error'      => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $penjualan = Penjualan::with(['pelanggan', 'itemPenjualans.barang'])->find($id);

            if (!$penjualan) {
                return response()->json([
                    'statusCode' => 404,
                    'status'     => 'error',
                    'message'    => 'Penjualan dengan ID ' . $id . ' tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Berhasil mengambil detail penjualan',
                'data'       => $penjualan,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Terjadi kesalahan saat mengambil detail penjualan',
                'error'      => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $penjualan = Penjualan::with('itemPenjualans')->find($id);

            if (!$penjualan) {
                return response()->json([
                    'statusCode' => 404,
                    'status'     => 'error',
                    'message'    => 'Penjualan dengan ID ' . $id . ' tidak ditemukan',
                ], 404);
            }

            $validated = $request->validate([
                'tgl' => 'required|date',
                'pelanggan_id' => 'required|exists:pelanggans,id',
                'items' => 'required|array|min:1',
                'items.*.barang_id' => 'required|exists:barangs,id',
                'items.*.qty' => 'required|integer|min:1',
            ]);

            DB::beginTransaction();

            // update tgl dan pelanggan
            $penjualan->update([
                'tgl' => $validated['tgl'],
                'pelanggan_id' => $validated['pelanggan_id'],
            ]);

            // hapus item penjualan lama
            $penjualan->itemPenjualans()->delete();

            // insert item penjualan baru & hitung subtotal
            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                $lineSubtotal = $barang->harga * $item['qty'];
                $subtotal += $lineSubtotal;

                ItemPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $barang->id,
                    'qty' => $item['qty'],
                ]);
            }

            $penjualan->update(['subtotal' => $subtotal]);

            DB::commit();

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Penjualan berhasil diupdate',
                'data'       => $penjualan->load(['pelanggan', 'itemPenjualans.barang']),
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Gagal mengupdate penjualan',
                'error'      => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $penjualan = Penjualan::find($id);

            if (!$penjualan) {
                return response()->json([
                    'statusCode' => 404,
                    'status'     => 'error',
                    'message'    => 'Penjualan dengan ID ' . $id . ' tidak ditemukan',
                ], 404);
            }

            $penjualan->delete();

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Penjualan berhasil dihapus',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Gagal menghapus penjualan',
                'error'      => $e->getMessage(),
            ], 500);
        }
    }
}
