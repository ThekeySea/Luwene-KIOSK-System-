    <div class="min-h-dvh bg-dark-950">
        <header class="bg-dark-900 border-b border-dark-800 sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-display font-bold text-white">LUWENE <span class="text-primary">Admin</span></h1>
                    <p class="text-xs text-warm-400">Dashboard</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-warm-300">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-warm-400 hover:text-red-400 transition">Keluar</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto p-4">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <div class="bg-dark-900 rounded-2xl p-5 border border-dark-800">
                    <p class="text-xs text-warm-400">Total Pesanan</p>
                    <p class="text-2xl font-display font-bold text-white mt-1">{{ number_format($totalOrders) }}</p>
                </div>
                <div class="bg-dark-900 rounded-2xl p-5 border border-dark-800">
                    <p class="text-xs text-warm-400">Total Pendapatan</p>
                    <p class="text-2xl font-display font-bold text-accent mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-dark-900 rounded-2xl p-5 border border-dark-800">
                    <p class="text-xs text-warm-400">Pesanan Hari Ini</p>
                    <p class="text-2xl font-display font-bold text-white mt-1">{{ $todayOrders }}</p>
                </div>
                <div class="bg-dark-900 rounded-2xl p-5 border border-dark-800">
                    <p class="text-xs text-warm-400">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-display font-bold text-accent mt-1">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                <div class="bg-dark-900 rounded-2xl p-5 border border-dark-800">
                    <p class="text-xs text-warm-400">Total Pengguna</p>
                    <p class="text-2xl font-display font-bold text-white mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="bg-dark-900 rounded-2xl p-5 border border-dark-800">
                    <p class="text-xs text-warm-400">Total Produk</p>
                    <p class="text-2xl font-display font-bold text-white mt-1">{{ $totalProducts }}</p>
                </div>
            </div>

            <div class="bg-dark-900 rounded-2xl border border-dark-800 overflow-hidden">
                <div class="px-5 py-4 border-b border-dark-800">
                    <h2 class="font-display font-bold text-white">Pesanan Terbaru</h2>
                </div>
                <div class="divide-y divide-dark-800">
                    @forelse ($recentOrders as $order)
                        <div class="px-5 py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-white font-medium">#{{ $order->order_number }}</p>
                                <p class="text-xs text-warm-400">{{ $order->user->name ?? 'Guest' }} &middot; {{ $order->created_at->format('H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-accent">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                <span class="inline-block text-xs px-2 py-0.5 rounded-full
                                    @if($order->status === 'PENDING') bg-yellow-500/20 text-yellow-400
                                    @elseif($order->status === 'COMPLETED') bg-green-500/20 text-green-400
                                    @else bg-blue-500/20 text-blue-400
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-8 text-center text-warm-500 text-sm">Belum ada pesanan</div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
