<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Exception;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Pelanggan::all();

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Berhasil mengambil semua data pelanggan',
                'data'       => $data,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Terjadi kesalahan saat mengambil data pelanggan',
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
                'nama'          => 'required|string',
                'domisili'      => 'required|in:JAK-UT,JAK-BAR,JAK-SEL,JAK-TIM',
                'jenis_kelamin' => 'required|in:PRIA,WANITA',
            ]);

            $pelanggan = Pelanggan::create($validated);

            return response()->json([
                'statusCode' => 201,
                'status'     => 'success',
                'message'    => 'Pelanggan berhasil ditambahkan',
                'data'       => $pelanggan,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Gagal menambahkan pelanggan',
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
            $pelanggan = Pelanggan::find($id);

            if (!$pelanggan) {
                return response()->json([
                    'statusCode' => 404,
                    'status'     => 'error',
                    'message'    => 'Pelanggan dengan ID ' . $id . ' tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Berhasil mengambil detail pelanggan',
                'data'       => $pelanggan,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Terjadi kesalahan saat mengambil detail pelanggan',
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
            $pelanggan = Pelanggan::find($id);

            if (!$pelanggan) {
                return response()->json([
                    'statusCode' => 404,
                    'status'     => 'error',
                    'message'    => 'Pelanggan dengan ID ' . $id . ' tidak ditemukan',
                ], 404);
            }

            $validated = $request->validate([
                'nama'          => 'sometimes|required|string',
                'domisili'      => 'sometimes|required|in:JAK-UT,JAK-BAR,JAK-SEL,JAK-TIM',
                'jenis_kelamin' => 'sometimes|required|in:PRIA,WANITA',
            ]);

            $pelanggan->update($validated);

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Pelanggan berhasil diupdate',
                'data'       => $pelanggan,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Gagal mengupdate pelanggan',
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
            $pelanggan = Pelanggan::find($id);

            if (!$pelanggan) {
                return response()->json([
                    'statusCode' => 404,
                    'status'     => 'error',
                    'message'    => 'Pelanggan dengan ID ' . $id . ' tidak ditemukan',
                ], 404);
            }

            $pelanggan->delete();

            return response()->json([
                'statusCode' => 200,
                'status'     => 'success',
                'message'    => 'Pelanggan berhasil dihapus',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'status'     => 'error',
                'message'    => 'Gagal menghapus pelanggan',
                'error'      => $e->getMessage(),
            ], 500);
        }
    }
}
