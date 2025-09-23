<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    public function itemPenjualans()
    {
        return $this->hasMany(ItemPenjualan::class);
    }

}
