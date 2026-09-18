    <div class="min-h-dvh bg-dark-950">
        <header class="bg-dark-900 border-b border-dark-800 sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('cashier.dashboard') }}" class="text-warm-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-lg font-display font-bold text-white">POS</h1>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-warm-300">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto p-4">
            <div class="bg-dark-900 rounded-2xl border border-dark-800 overflow-hidden">
                <div class="px-5 py-4 border-b border-dark-800">
                    <h2 class="font-display font-bold text-white">Pesanan Aktif</h2>
                </div>
                <div class="divide-y divide-dark-800">
                    @forelse ($pendingOrders as $order)
                        <div class="px-5 py-4">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="text-sm font-bold text-white">#{{ $order->order_number }}</p>
                                    <p class="text-xs text-warm-400">{{ $order->order_mode }} &middot; {{ $order->created_at->format('H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-accent">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    <span class="inline-block text-xs px-2 py-0.5 rounded-full font-medium
                                        @if($order->status === 'PENDING') bg-yellow-500/20 text-yellow-400
                                        @elseif($order->status === 'CONFIRMED') bg-blue-500/20 text-blue-400
                                        @elseif($order->status === 'PREPARING') bg-orange-500/20 text-orange-400
                                        @else bg-green-500/20 text-green-400
                                        @endif">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex gap-2 mt-3">
                                @if($order->status === 'PENDING')
                                    <button class="px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded-lg hover:bg-blue-600 transition">Konfirmasi</button>
                                @elseif($order->status === 'CONFIRMED')
                                    <button class="px-3 py-1.5 bg-orange-500 text-white text-xs font-medium rounded-lg hover:bg-orange-600 transition">Siapkan</button>
                                @elseif($order->status === 'PREPARING')
                                    <button class="px-3 py-1.5 bg-green-500 text-white text-xs font-medium rounded-lg hover:bg-green-600 transition">Siap</button>
                                @elseif($order->status === 'READY')
                                    <button class="px-3 py-1.5 bg-green-500 text-white text-xs font-medium rounded-lg hover:bg-green-600 transition">Selesai</button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-12 text-center text-warm-500 text-sm">Tidak ada pesanan aktif</div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
