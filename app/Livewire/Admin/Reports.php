<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reports extends Component
{
    public string $preset = 'today';

    public function setPreset(string $preset): void
    {
        $this->preset = in_array($preset, ['today', 'week', 'month'], true) ? $preset : 'today';
    }

    protected function range(): array
    {
        return match ($this->preset) {
            'week' => [now()->subDays(6)->startOfDay(), now()->endOfDay()],
            'month' => [now()->subDays(29)->startOfDay(), now()->endOfDay()],
            default => [now()->startOfDay(), now()->endOfDay()],
        };
    }

    public function render()
    {
        [$from, $to] = $this->range();

        $base = Order::whereBetween('created_at', [$from, $to]);
        $paid = (clone $base)->where('payment_status', 'PAID');

        $revenue = (float) (clone $paid)->sum('total_amount');
        $orderCount = (clone $base)->count();
        $paidCount = (clone $paid)->count();

        $byStatus = (clone $base)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $byMode = (clone $base)
            ->select('order_mode', DB::raw('count(*) as total'))
            ->groupBy('order_mode')
            ->pluck('total', 'order_mode');

        $byPayment = DB::table('payments')
            ->join('orders', 'orders.id', '=', 'payments.order_id')
            ->whereBetween('orders.created_at', [$from, $to])
            ->where('orders.payment_status', 'PAID')
            ->select('payments.method', DB::raw('count(*) as total'), DB::raw('sum(payments.amount) as revenue'))
            ->groupBy('payments.method')
            ->get();

        $topProducts = OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$from, $to])
            ->where('orders.status', '!=', 'CANCELLED')
            ->select('order_items.product_name', DB::raw('sum(order_items.quantity) as qty'), DB::raw('sum(order_items.subtotal) as revenue'))
            ->groupBy('order_items.product_name')
            ->orderByDesc('qty')
            ->limit(5)
            ->get();

        $fromLabel = $from->format('d M Y');
        $toLabel = $to->format('d M Y');

        return view('livewire.admin.reports', [
            'revenue' => $revenue,
            'orderCount' => $orderCount,
            'paidCount' => $paidCount,
            'average' => $paidCount > 0 ? $revenue / $paidCount : 0,
            'byStatus' => $byStatus,
            'byMode' => $byMode,
            'byPayment' => $byPayment,
            'topProducts' => $topProducts,
            'fromLabel' => $fromLabel,
            'toLabel' => $toLabel,
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Laporan',
            'pageActions' => '<span class="text-sm text-gray-400">'.$fromLabel.' &#8211; '.$toLabel.'</span>',
        ]);
    }
}
