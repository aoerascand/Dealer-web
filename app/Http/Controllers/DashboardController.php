<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $orderQuery = Order::query();
        $transactionQuery = Transaction::query();

        if ($filter == 'today') {
            $orderQuery->whereDate('created_at', today());
            $transactionQuery->whereDate('payment_time', today());
        } elseif ($filter == 'month') {
            $orderQuery->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            $transactionQuery->whereMonth('payment_time', date('m'))->whereYear('payment_time', date('Y'));
        } elseif ($filter == 'year') {
            $orderQuery->whereYear('created_at', date('Y'));
            $transactionQuery->whereYear('payment_time', date('Y'));
        }

        $totalProducts = Product::count(); // Stok total selalu global
        
        $totalOrders = (clone $orderQuery)->count();
        $pendingOrders = (clone $orderQuery)->where('status', 'pending')->count();
        $completedOrdersCount = (clone $orderQuery)->where('status', 'completed')->count();
        $totalRevenue = (clone $transactionQuery)->sum('amount');
        
        $topProducts = (clone $orderQuery)->where('status', 'completed')
                        ->select('product_id', \DB::raw('count(*) as total_sales'))
                        ->with('product')
                        ->groupBy('product_id')
                        ->orderByDesc('total_sales')
                        ->limit(5)
                        ->get();

        if ($filter == 'year') {
            // Group by month
            $chartData = (clone $orderQuery)->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date', 'ASC')
                    ->get();
        } else {
            // Group by day 
            // If it's all, limit to last 30 days to avoid cluttering chart
            if($filter == 'all') {
                $orderQuery->whereRaw('created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)');
            }
            $chartData = (clone $orderQuery)->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date', 'ASC')
                    ->get();
        }
                    
        return view('bos.dashboard', compact('totalProducts', 'totalOrders', 'totalRevenue', 'pendingOrders', 'completedOrdersCount', 'chartData', 'topProducts', 'filter'));
    }

    public function laporan(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $transactionQuery = Transaction::query();

        if ($filter == 'today') {
            $transactionQuery->whereDate('payment_time', today());
        } elseif ($filter == 'month') {
            $transactionQuery->whereMonth('payment_time', date('m'))->whereYear('payment_time', date('Y'));
        } elseif ($filter == 'year') {
            $transactionQuery->whereYear('payment_time', date('Y'));
        }

        $transactions = $transactionQuery->with(['order', 'order.user', 'order.product'])
                            ->latest('payment_time')
                            ->paginate(20)
                            ->withQueryString();

        return view('bos.laporan', compact('transactions', 'filter'));
    }
}