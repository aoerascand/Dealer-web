<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Metrik Utama
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        
        // Total Pendapatan berdasarkan transaksi valid
        $totalRevenue = Transaction::sum('amount');
        
        $pendingOrders = Order::where('status', 'pending')->count();
        
        // Data chart sederhana: Pesanan per hari dalam 7 hari terakhir
        $chartData = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->whereRaw('created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)')
                    ->groupBy('date')
                    ->orderBy('date', 'ASC')
                    ->get();
                    
        return view('bos.dashboard', compact('totalProducts', 'totalOrders', 'totalRevenue', 'pendingOrders', 'chartData'));
    }
}