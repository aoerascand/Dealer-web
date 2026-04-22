<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'warna', 'stok', 'gambar'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
