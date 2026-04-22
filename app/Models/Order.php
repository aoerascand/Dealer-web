<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'user_id',
        'product_id',
        'product_variant_id',
        'nama_pembeli',
        'total_harga',
        'deskripsi_tambahan',
        'status',
        'snap_token'
    ];
      public function product()
   {
    return $this->belongsTo(Product::class);
   }

   public function variant()
   {
    return $this->belongsTo(ProductVariant::class, 'product_variant_id');
   }

   public function user()
   {
    return $this->belongsTo(User::class);
   }

   public function transaction()
   {
    return $this->hasOne(Transaction::class);
   }
}
