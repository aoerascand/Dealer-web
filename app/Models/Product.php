<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama_produk',
        'stok',
        'harga',
        'gambar',
        'deskripsi'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
