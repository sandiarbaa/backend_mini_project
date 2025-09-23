<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::namespace('App\Http\Controllers\Api')->group(function () {
    Route::apiResource('pelanggans', 'PelangganController');
    Route::apiResource('barangs', 'BarangController');
    Route::apiResource('penjualans', 'PenjualanController');
    Route::apiResource('item-penjualans', 'ItemPenjualanController');
});
