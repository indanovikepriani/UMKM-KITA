<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // --- KPI: Current Month ---
        $totalSales = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('total');

        $totalPurchases = OrderItem::whereHas('order', function ($q) use ($startOfMonth) {
            $q->where('created_at', '>=', $startOfMonth);
        })->sum('quantity');

        $totalPaid = Payment::where('status', 'success')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('amount');

        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $totalProfit = $totalRevenue * 0.3;

        // --- KPI: Last Month (for trend comparison) ---
        $lastMonthSales = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total');

        $lastMonthPurchases = OrderItem::whereHas('order', function ($q) use ($startOfLastMonth, $endOfLastMonth) {
            $q->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
        })->sum('quantity');

        $lastMonthPaid = Payment::where('status', 'success')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('amount');

        $lastMonthRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total');
        $lastMonthProfit = $lastMonthRevenue * 0.3;

        // --- Trend Percentages ---
        $trends = [
            'sales'       => $this->calcTrend($totalSales, $lastMonthSales),
            'purchases'   => $this->calcTrend($totalPurchases, $lastMonthPurchases),
            'paid'        => $this->calcTrend($totalPaid, $lastMonthPaid),
            'profit'      => $this->calcTrend($totalProfit, $lastMonthProfit),
        ];

        // --- KPI Data ---
        $kpi = [
            'total_sales'     => $totalSales,
            'total_purchases' => $totalPurchases,
            'total_paid'      => $totalPaid,
            'total_profit'    => $totalProfit,
        ];

        // --- Chart: Monthly Sales (12 months) ---
        $monthlySales = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $revenue = Order::where('payment_status', 'paid')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total');
            $monthlySales->push([
                'month' => $month->format('M Y'),
                'total' => floatval($revenue),
            ]);
        }

        // --- Chart: Top Selling Products (top 5 by quantity sold) ---
        $topSellingProducts = Product::withCount([
                'orderItems as sold_quantity' => function ($query) {
                    $query->whereHas('order', function ($q) {
                        $q->where('payment_status', 'paid');
                    });
                }
            ])
            ->whereHas('orderItems', function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('payment_status', 'paid');
                });
            })
            ->orderByDesc('sold_quantity')
            ->take(5)
            ->get();

        $totalSoldAll = $topSellingProducts->sum('sold_quantity') ?: 1;

        // --- Table: Inventory Products ---
        $inventoryProducts = Product::with('category')->latest()->paginate(10);

        // --- Stats for header ---
        $pendingTestimonials = \App\Models\Review::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'kpi',
            'trends',
            'monthlySales',
            'topSellingProducts',
            'totalSoldAll',
            'inventoryProducts',
            'pendingTestimonials'
        ));
    }

    private function calcTrend($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100.0 : 0.0;
        }
        return round((($current - $previous) / $previous) * 100, 1);
    }
}
