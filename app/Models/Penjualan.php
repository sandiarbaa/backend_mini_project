<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function itemPenjualans()
    {
        return $this->hasMany(ItemPenjualan::class);
    }
}
