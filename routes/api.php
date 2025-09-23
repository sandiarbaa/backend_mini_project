<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Api')->group(function () {
    Route::apiResource('pelanggans', 'PelangganController');
    Route::apiResource('barangs', 'BarangController');
    Route::apiResource('penjualans', 'PenjualanController');
    Route::apiResource('item-penjualans', 'ItemPenjualanController');
});
