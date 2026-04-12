<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // --- KHUSUS KARYAWAN --- //
    public function index()
    {
        $orders = Order::with('user', 'product')->latest()->get();
        return view('karyawan.orders.index', compact('orders'));
    }

    public function complete($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status == 'pending') {
            $order->update(['status' => 'completed']);
            $order->product->decrement('stok');

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

    public function create()
    {
        $products = Product::where('stok', '>', 0)->get();
        return view('karyawan.orders.create', compact('products'));
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
            'nama_pembeli' => $request->nama_pembeli,
            'total_harga' => $product->harga,
            'deskripsi_tambahan' => $request->deskripsi_tambahan,
            'status' => 'pending' // Setelah diorder, bisa dicheckout atau dibayar di tempat
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan baru berhasil dicatat.');
    }


    // --- KHUSUS PELANGGAN --- //
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('pelanggan.my-orders', compact('orders'));
    }

    public function checkout(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'nama_pembeli' => $request->nama_pembeli ?? Auth::user()->name,
            'total_harga' => $product->harga,
            'deskripsi_tambahan' => $request->deskripsi_tambahan,
            'status' => 'pending',
        ]);

        Config::$serverKey = config('services.midtrans.serverKey', env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-YOURSERVERKEY'));
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'     => 'ORDER-' . $order->id . '-' . time(),
                'gross_amount' => (int)$order->total_harga,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $order->update(['snap_token' => $snapToken]);

        return view('orders.pembayaran', compact('order', 'snapToken'));
    }
    
    public function payment($id)
    {
        $order = Order::findOrFail($id);
        if ($order->user_id !== Auth::id()) abort(403);
        
        $snapToken = $order->snap_token;
        return view('orders.pembayaran', compact('order', 'snapToken'));
    }

    // --- API Hook Midtrans --- //
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.serverKey', env('MIDTRANS_SERVER_KEY'));
        // HMAC validation typically needed:
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $orderIdPattern = explode('-', $request->order_id);
                $orderIdStr = count($orderIdPattern) > 1 ? $orderIdPattern[1] : null;
                if (!$orderIdStr) return response()->json(['message' => 'Invalid order id format']);
                
                $order = Order::find($orderIdStr);
                if ($order && $order->status == 'pending') {
                    $order->update(['status' => 'completed']);
                    
                    // Buat record di tabel transaksi
                    Transaction::create([
                        'order_id' => $order->id,
                        'transaction_id_midtrans' => $request->transaction_id,
                        'payment_type' => $request->payment_type,
                        'amount' => $request->gross_amount,
                        'payment_time' => $request->transaction_time,
                    ]);

                    // Kurangi Stok Motor
                    $order->product->decrement('stok');
                }
            }
        }
        return response()->json(['message' => 'Callback handled']);
    }
}