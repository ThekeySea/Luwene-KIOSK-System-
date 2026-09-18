    <div class="min-h-dvh bg-dark-950">
        <header class="bg-dark-900 border-b border-dark-800 sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-display font-bold text-white">LUWENE <span class="text-accent">POS</span></h1>
                    <p class="text-xs text-warm-400">Kasir</p>
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
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-dark-900 rounded-2xl p-5 border border-dark-800">
                    <p class="text-sm text-warm-400">Pesanan Hari Ini</p>
                    <p class="text-3xl font-display font-bold text-white mt-1">{{ $todayOrders }}</p>
                </div>
                <div class="bg-dark-900 rounded-2xl p-5 border border-dark-800">
                    <p class="text-sm text-warm-400">Pendapatan Hari Ini</p>
                    <p class="text-3xl font-display font-bold text-accent mt-1">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-dark-900 rounded-2xl p-5 border border-dark-800">
                    <p class="text-sm text-warm-400">Menunggu Diproses</p>
                    <p class="text-3xl font-display font-bold text-primary mt-1">{{ $pendingOrders }}</p>
                </div>
            </div>

            <a href="{{ route('cashier.pos') }}" class="block bg-accent rounded-2xl p-6 text-center hover:bg-accent/90 transition">
                <svg class="w-12 h-12 text-white mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                <h2 class="text-xl font-display font-bold text-white">Buka POS</h2>
                <p class="text-sm text-white/70 mt-1">Mulai menerima pesanan</p>
            </a>
        </main>
    </div>
