<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Exception;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Barang::all();

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Berhasil mengambil semua data barang',
                'data'       => $data,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Terjadi kesalahan saat mengambil data barang',
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
                'nama'     => 'required|string',
                'kategori' => 'required|in:ATK,RT,MASAK,ELEKTRONIK',
                'harga'    => 'required|numeric|min:0',
            ]);

            $barang = Barang::create($validated);

            return response()->json([
                'statusCode' => 201,
                'status'     => 'success',
                'message'    => 'Barang berhasil ditambahkan',
                'data'       => $barang,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Gagal menambahkan barang',
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
            $barang = Barang::find($id);

            if (!$barang) {
                return response()->json([
                    'statusCode' => 404,
                    'status'     => 'error',
                    'message'    => 'Barang dengan ID ' . $id . ' tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Berhasil mengambil detail barang',
                'data'       => $barang,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Terjadi kesalahan saat mengambil detail barang',
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
            $barang = Barang::find($id);

            if (!$barang) {
                return response()->json([
                    'statusCode' => 404,
                    'status'     => 'error',
                    'message'    => 'Barang dengan ID ' . $id . ' tidak ditemukan',
                ], 404);
            }

            $validated = $request->validate([
                'nama'     => 'sometimes|required|string',
                'kategori' => 'sometimes|required|in:ATK,RT,MASAK,ELEKTRONIK',
                'harga'    => 'sometimes|required|numeric|min:0',
            ]);

            $barang->update($validated);

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Barang berhasil diupdate',
                'data'       => $barang,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Gagal mengupdate barang',
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
            $barang = Barang::find($id);

            if (!$barang) {
                return response()->json([
                    'statusCode' => 404,
                    'status'     => 'error',
                    'message'    => 'Barang dengan ID ' . $id . ' tidak ditemukan',
                ], 404);
            }

            $barang->delete();

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Barang berhasil dihapus',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Gagal menghapus barang',
                'error'      => $e->getMessage(),
            ], 500);
        }
    }
}
