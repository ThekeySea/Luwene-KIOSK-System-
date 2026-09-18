<div class="min-h-dvh flex flex-col items-center justify-center p-6 bg-gradient-to-br from-dark-900 via-dark-800 to-primary-950">
    <div class="w-full max-w-sm">
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-accent/10 mb-6">
                <span class="text-4xl">🔥</span>
            </div>
            <h1 class="text-4xl font-bold text-white tracking-tight">LUWENE</h1>
            <p class="text-sm text-warm-400 mt-2 tracking-wide uppercase font-medium">Indonesian Modern Fast Food</p>
        </div>

        @if($error)
            <div class="mb-6 p-4 bg-primary-500/10 border border-primary-500/20 rounded-xl text-sm text-primary-300">
                {{ $error }}
            </div>
        @endif

        @if($selectedMode === 'DINE_IN' && $scannedTableId)
            <div class="mb-8 p-6 bg-dark-700/50 border border-dark-600 rounded-2xl text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-accent/10 mb-4">
                    <span class="text-3xl">🍽️</span>
                </div>
                <p class="text-xs text-warm-400 uppercase tracking-wider font-medium">Meja Terdeteksi</p>
                <p class="text-2xl font-bold text-white mt-1">Meja {{ $scannedTableName }}</p>
                <button wire:click="confirmDineIn"
                        class="mt-5 w-full bg-accent hover:bg-accent-500 text-white py-3.5 rounded-xl font-bold text-sm active:scale-[0.98] transition-all shadow-lg shadow-accent/20">
                    Mulai Pesan
                </button>
            </div>
        @elseif($selectedMode === 'TAKE_AWAY')
            <div class="mb-8 p-6 bg-dark-700/50 border border-dark-600 rounded-2xl text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-accent/10 mb-4">
                    <span class="text-3xl">🥡</span>
                </div>
                <p class="text-xs text-warm-400 uppercase tracking-wider font-medium">Take Away</p>
                <p class="text-lg font-semibold text-warm-200 mt-1">Ambil pesanan di kasir</p>
                <button wire:click="confirmTakeAway"
                        class="mt-5 w-full bg-accent hover:bg-accent-500 text-white py-3.5 rounded-xl font-bold text-sm active:scale-[0.98] transition-all shadow-lg shadow-accent/20">
                    Mulai Pesan
                </button>
            </div>
        @else
            <p class="text-center text-warm-400 mb-8 text-sm uppercase tracking-wider font-medium">Mau makan di mana?</p>

            <div class="space-y-4">
                <button wire:click="selectDineIn"
                        class="w-full p-6 bg-dark-700/50 border-2 border-dark-600 rounded-2xl text-center hover:border-accent/50 hover:bg-dark-700 transition-all active:scale-[0.98] group">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-accent/10 mb-4 group-hover:bg-accent/20 transition-colors">
                        <span class="text-3xl">🍽️</span>
                    </div>
                    <p class="font-bold text-white text-lg">Dine In</p>
                    <p class="text-xs text-warm-400 mt-1">Scan QR meja untuk memulai</p>
                </button>

                <button wire:click="selectTakeAway"
                        class="w-full p-6 bg-dark-700/50 border-2 border-dark-600 rounded-2xl text-center hover:border-accent/50 hover:bg-dark-700 transition-all active:scale-[0.98] group">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-accent/10 mb-4 group-hover:bg-accent/20 transition-colors">
                        <span class="text-3xl">🥡</span>
                    </div>
                    <p class="font-bold text-white text-lg">Take Away</p>
                    <p class="text-xs text-warm-400 mt-1">Ambil pesanan di kasir</p>
                </button>
            </div>
        @endif
    </div>
</div>
