<?php

namespace App\Livewire\Staff;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        // ─── Periode saat ini ────────────────────────────
        $monthStart = Carbon::now()->startOfMonth();
        $monthPrevStart = Carbon::now()->subMonth()->startOfMonth();
        $monthPrevEnd = Carbon::now()->subMonth()->endOfMonth();

        $weekStart = Carbon::now()->startOfWeek();
        $weekPrevStart = Carbon::now()->subWeek()->startOfWeek();
        $weekPrevEnd = Carbon::now()->subWeek()->endOfWeek();

        // ─── 1. Pendapatan bulanan (paid orders) ─────────
        $revenueCurrent = Order::where('payment_status', 'PAID')
            ->where('created_at', '>=', $monthStart)
            ->sum('total_amount');

        $revenuePrevious = Order::where('payment_status', 'PAID')
            ->whereBetween('created_at', [$monthPrevStart, $monthPrevEnd])
            ->sum('total_amount');

        // ─── 2. Jumlah order mingguan (distinct orders) ──
        $ordersCurrent = Order::where('created_at', '>=', $weekStart)->count();

        $ordersPrevious = Order::whereBetween('created_at', [$weekPrevStart, $weekPrevEnd])->count();

        // ─── 3. Total item terbeli bulanan ───────────────
        $itemsCurrent = OrderItem::whereHas('order', function ($q) use ($monthStart) {
            $q->where('created_at', '>=', $monthStart);
        })->sum('quantity');

        $itemsPrevious = OrderItem::whereHas('order', function ($q) use ($monthPrevStart, $monthPrevEnd) {
            $q->whereBetween('created_at', [$monthPrevStart, $monthPrevEnd]);
        })->sum('quantity');

        // ─── 4. Total produk ─────────────────────────────
        $totalProducts = Product::count();

        // ─── 5. Delivery stats ──────────────────────────
        $deliveryOrders = Order::where('order_mode', 'DELIVERY')
            ->where('created_at', '>=', $monthStart)
            ->count();
        $deliveryRevenue = Order::where('order_mode', 'DELIVERY')
            ->where('payment_status', 'PAID')
            ->where('created_at', '>=', $monthStart)
            ->sum('total_amount');
        $activeDelivery = Order::where('order_mode', 'DELIVERY')
            ->whereIn('status', ['PENDING', 'CONFIRMED', 'PREPARING', 'READY', 'OUT_FOR_DELIVERY'])
            ->count();

        // ─── Trend percentages ───────────────────────────
        $revenueTrend = $this->calcTrend($revenueCurrent, $revenuePrevious);
        $ordersTrend = $this->calcTrend($ordersCurrent, $ordersPrevious);
        $itemsTrend = $this->calcTrend($itemsCurrent, $itemsPrevious);

        // ─── Pesanan terbaru ─────────────────────────────
        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(15)
            ->get();

        return view('livewire.staff.admin-dashboard', [
            'revenueCurrent' => $revenueCurrent,
            'revenueTrend' => $revenueTrend,
            'ordersCurrent' => $ordersCurrent,
            'ordersTrend' => $ordersTrend,
            'itemsCurrent' => $itemsCurrent,
            'itemsTrend' => $itemsTrend,
            'totalProducts' => $totalProducts,
            'deliveryOrders' => $deliveryOrders,
            'deliveryRevenue' => $deliveryRevenue,
            'activeDelivery' => $activeDelivery,
            'recentOrders' => $recentOrders,
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Dashboard',
        ]);
    }

    private function calcTrend(float $current, float $previous): array
    {
        if ($previous == 0) {
            return ['percent' => $current > 0 ? 100 : 0, 'direction' => $current >= 0 ? 'up' : 'flat'];
        }

        $change = (($current - $previous) / $previous) * 100;

        return [
            'percent' => round(abs($change), 1),
            'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'flat'),
        ];
    }
}
