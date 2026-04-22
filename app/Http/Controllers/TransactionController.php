<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        // Fungsi Entry Transaksi Manual untuk Karyawan jika pelanggan bayar langsung
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_type' => 'required|string',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->status == 'completed') {
            return back()->with('error', 'Pesanan ini sudah selesai.');
        }

        $order->update(['status' => 'completed']);
        $order->product->decrement('stok');
        if($order->product_variant_id) {
            $order->variant->decrement('stok');
        }

        Transaction::create([
            'order_id' => $order->id,
            'transaction_id_midtrans' => 'MANUAL-' . time(),
            'payment_type' => $request->payment_type, // Misal: cash, transfer_bank
            'amount' => $order->total_harga,
            'payment_time' => now(),
        ]);

        return back()->with('success', 'Transaksi berhasil dicatat dan diselesaikan.');
    }
}
