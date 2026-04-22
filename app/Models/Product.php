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

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    
    public function getDefaultGambarAttribute()
    {
        if (!empty($this->attributes['gambar'])) {
            return $this->attributes['gambar'];
        }
        $firstVariant = $this->variants()->first();
        return $firstVariant ? $firstVariant->gambar : null;
    }
    
    public function getTotalStokAttribute()
    {
        // Jika belum ada varian, fallback ke stok konvensional
        if($this->variants()->count() == 0) {
            return $this->attributes['stok'];
        }
        return $this->variants->sum('stok');
    }
}
