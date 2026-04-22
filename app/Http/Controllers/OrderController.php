<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // --- KHUSUS KARYAWAN --- //
    public function dashboard()
    {
        $orders = Order::with('user', 'product', 'variant')->latest()->take(10)->get();
        return view('karyawan.dashboard', compact('orders'));
    }

    public function produk()
    {
        $products = Product::with('variants')->get();
        return view('karyawan.produk', compact('products'));
    }

    public function complete($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status == 'pending') {
            $order->update(['status' => 'completed']);
            
            // Kurangi stok utama
            $order->product->decrement('stok');

            // Kurangi stok varian jika ada
            if($order->product_variant_id) {
                $order->variant->decrement('stok');
            }

            Transaction::create([
                'order_id' => $order->id,
                'transaction_id_midtrans' => null, // Manual
                'payment_type' => 'manual',
                'amount' => $order->total_harga,
                'payment_time' => now(),
            ]);

            return back()->with('success', 'Pesanan secara manual ditandai selesai.');
        }
        return back()->with('error', 'Pesanan ini tidak dapat dirubah.');
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status == 'pending') {
            $order->update(['status' => 'gagal']);
            return back()->with('success', 'Pesanan berhasil dibatalkan / ditandai gagal.');
        }
        return back()->with('error', 'Pesanan ini sudah diproses dan tidak dapat dibatalkan.');
    }

    public function create()
    {
        $products = Product::with('variants')->where('stok', '>', 0)->get();
        return view('karyawan.entry', compact('products'));
    }
    
    public function store(Request $request)
    {
        // Entry pesanan manual (Karyawan)
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'nama_pembeli' => 'required|string|max:255',
            'deskripsi_tambahan' => 'nullable|string'
        ]);

        $product = Product::findOrFail($request->product_id);

        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'product_variant_id' => $request->product_variant_id, // Untuk warna yang dipilih
            'nama_pembeli' => $request->nama_pembeli,
            'total_harga' => $product->harga,
            'deskripsi_tambahan' => $request->deskripsi_tambahan,
            'status' => 'pending' // Setelah diorder, bisa dicheckout atau dibayar di tempat
        ]);

        return redirect()->route('staff.dashboard')->with('success', 'Pesanan baru berhasil dicatat.');
    }


    // --- KHUSUS PELANGGAN --- //
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('pelanggan.my-orders', compact('orders'));
    }

    public function receipt(Order $order)
    {
        if ($order->user_id != Auth::id() && Auth::user()->role == 'pelanggan') {
            abort(403, 'Unauthorized access.');
        }

        $order->load(['product', 'variant', 'transaction']);
        return view('pelanggan.receipt', compact('order'));
    }

    public function checkout(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'product_variant_id' => $request->product_variant_id,
            'nama_pembeli' => $request->nama_pembeli ?? Auth::user()->name,
            'total_harga' => $product->harga,
            'deskripsi_tambahan' => $request->deskripsi_tambahan,
            'status' => 'pending',
        ]);

        return redirect()->route('my-orders')->with('success', 'Pesanan berhasil dibuat. Silahkan datang ke dealer untuk proses selanjutnya.');
    }
}