<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'transaction_id_midtrans',
        'payment_type',
        'amount',
        'payment_time'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
