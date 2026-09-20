<div wire:poll.15s>
    {{-- ═══ BENTO GRID: Ringkasan ═══ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        {{-- ── Pendapatan Bulanan ── --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 col-span-2 lg:col-span-1">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pendapatan</p>
                    <p class="text-xs text-gray-400 mt-0.5">Sebulan terakhir</p>
                </div>
                @include('livewire.staff.partials._trend-badge', ['trend' => $revenueTrend])
            </div>
            <p class="text-2xl font-display font-bold text-primary mt-3">Rp {{ number_format($revenueCurrent, 0, ',', '.') }}</p>
        </div>

        {{-- ── Pesanan Mingguan ── --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pesanan</p>
                    <p class="text-xs text-gray-400 mt-0.5">Sepekan terakhir</p>
                </div>
                @include('livewire.staff.partials._trend-badge', ['trend' => $ordersTrend])
            </div>
            <p class="text-2xl font-display font-bold text-gray-900 mt-3">{{ number_format($ordersCurrent) }}</p>
        </div>

        {{-- ── Item Terbeli ── --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Menu Terjual</p>
                    <p class="text-xs text-gray-400 mt-0.5">Sebulan terakhir</p>
                </div>
                @include('livewire.staff.partials._trend-badge', ['trend' => $itemsTrend])
            </div>
            <p class="text-2xl font-display font-bold text-gray-900 mt-3">{{ number_format($itemsCurrent) }}</p>
        </div>

        {{-- ── Total Produk ── --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Produk</p>
            <p class="text-2xl font-display font-bold text-gray-900 mt-3">{{ number_format($totalProducts) }}</p>
        </div>
    </div>

    {{-- ═══ SHORTCUT: Buka KIOSK ═══ --}}
    <div class="mb-6">
        <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-4 bg-gradient-to-r from-primary to-accent rounded-xl p-5 text-white hover:shadow-lg hover:scale-[1.01] transition-all duration-200">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-bold">Buka Kiosk Pelanggan</p>
                <p class="text-xs text-white/70">Lihat tampilan menu yang dilihat pelanggan</p>
            </div>
            <svg class="w-5 h-5 ml-auto shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
        </a>
    </div>

    {{-- ═══ PESANAN TERBARU (Realtime) ═══ --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-display font-bold text-gray-900">Pesanan Terbaru</h2>
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
            </span>
        </div>
        <div class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto">
            @forelse ($recentOrders as $order)
                <div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-semibold text-gray-900">#{{ $order->order_number }}</p>
                            <span class="inline-block text-[10px] px-2 py-0.5 rounded-full font-medium
                                @if($order->status === 'PENDING') bg-yellow-100 text-yellow-700
                                @elseif($order->status === 'CONFIRMED') bg-blue-100 text-blue-700
                                @elseif($order->status === 'PREPARING') bg-orange-100 text-orange-700
                                @elseif($order->status === 'READY') bg-purple-100 text-purple-700
                                @elseif($order->status === 'COMPLETED') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700
                                @endif">
                                {{ $order->status }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $order->customer_name ?? $order->user->name ?? 'Guest' }}
                            &middot; {{ $order->items->count() }} menu
                            &middot; {{ $order->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <p class="text-sm font-semibold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-gray-400">{{ $order->created_at->format('d M, H:i') }}</p>
                    </div>
                </div>
            @empty
                <div class="px-5 py-12 text-center text-gray-400 text-sm">Belum ada pesanan</div>
            @endforelse
        </div>
    </div>
</div>
