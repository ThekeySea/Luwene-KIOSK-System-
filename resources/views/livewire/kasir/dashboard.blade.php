<div class="min-h-dvh">
    <header class="sticky top-0 z-50 bg-dark-900/95 backdrop-blur-xl border-b border-dark-700">
        <div class="max-w-7xl mx-auto px-4 h-14 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="/" class="text-xl font-bold text-accent">LUWENE</a>
                <span class="text-[10px] px-2 py-0.5 bg-accent/15 text-accent rounded-full font-bold uppercase tracking-wider">Kasir</span>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <span class="text-warm-400">{{ now()->format('d M Y') }}</span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4">
        <div class="grid grid-cols-3 gap-3 mb-6">
            <div class="bg-dark-800 border border-dark-700 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-yellow-400">{{ $pendingCount }}</p>
                <p class="text-xs text-yellow-500/80 mt-1">Menunggu Pembayaran</p>
            </div>
            <div class="bg-dark-800 border border-dark-700 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-blue-400">{{ $preparingCount }}</p>
                <p class="text-xs text-blue-500/80 mt-1">Sedang Diproses</p>
            </div>
            <div class="bg-dark-800 border border-dark-700 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-green-400">{{ $readyCount }}</p>
                <p class="text-xs text-green-500/80 mt-1">Siap</p>
            </div>
        </div>

        <div class="mb-4 flex gap-2 flex-wrap items-center">
            <button wire:click="$set('statusFilter', 'all')"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold border transition-all
                    {{ $statusFilter === 'all' ? 'bg-accent text-white border-accent shadow-lg shadow-accent/20' : 'bg-dark-800 text-warm-400 border-dark-600 hover:border-dark-500' }}">
                Semua
            </button>
            <button wire:click="$set('statusFilter', 'PENDING_PAYMENT')"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold border transition-all
                    {{ $statusFilter === 'PENDING_PAYMENT' ? 'bg-yellow-500 text-white border-yellow-500' : 'bg-dark-800 text-warm-400 border-dark-600 hover:border-dark-500' }}">
                Menunggu Bayar
            </button>
            <button wire:click="$set('statusFilter', 'PREPARING')"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold border transition-all
                    {{ $statusFilter === 'PREPARING' ? 'bg-blue-500 text-white border-blue-500' : 'bg-dark-800 text-warm-400 border-dark-600 hover:border-dark-500' }}">
                Diproses
            </button>
            <button wire:click="$set('statusFilter', 'READY')"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold border transition-all
                    {{ $statusFilter === 'READY' ? 'bg-green-500 text-white border-green-500' : 'bg-dark-800 text-warm-400 border-dark-600 hover:border-dark-500' }}">
                Siap
            </button>
            <button wire:click="$set('statusFilter', 'COMPLETED')"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold border transition-all
                    {{ $statusFilter === 'COMPLETED' ? 'bg-warm-600 text-white border-warm-600' : 'bg-dark-800 text-warm-400 border-dark-600 hover:border-dark-500' }}">
                Selesai
            </button>
            <input type="text" wire:model.live.debounce.300ms="search"
                   placeholder="Cari order..."
                   class="ml-auto px-3 py-1.5 rounded-lg bg-dark-800 border border-dark-600 text-xs text-warm-200 placeholder-warm-500 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent/50">
        </div>

        @if(empty($orders))
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-dark-800 mb-4">
                    <span class="text-4xl">📋</span>
                </div>
                <p class="text-warm-500 text-sm">Tidak ada order</p>
            </div>
        @else
            <div class="grid gap-3">
                @foreach($orders as $order)
                    @php
                        $statusColor = match($order['status']) {
                            'PENDING_PAYMENT' => 'bg-yellow-500/15 text-yellow-400 border-yellow-500/30',
                            'PREPARING' => 'bg-blue-500/15 text-blue-400 border-blue-500/30',
                            'READY' => 'bg-green-500/15 text-green-400 border-green-500/30',
                            'COMPLETED' => 'bg-warm-500/15 text-warm-400 border-warm-500/30',
                            default => 'bg-dark-700 text-warm-400 border-dark-600',
                        };
                        $orderLabel = match($order['status']) {
                            'PENDING_PAYMENT' => 'Menunggu Bayar',
                            'PREPARING' => 'Diproses',
                            'READY' => 'Siap',
                            'COMPLETED' => 'Selesai',
                            default => $order['status'],
                        };
                    @endphp
                    <div class="bg-dark-800 rounded-xl border border-dark-700 p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <span class="font-bold text-sm text-white">{{ $order['order_number'] }}</span>
                                <span class="ml-2 text-xs text-warm-500">
                                    {{ $order['order_mode'] === 'DINE_IN' ? 'Meja ' . ($order['table']['table_number'] ?? '?') : 'Take Away' }}
                                </span>
                            </div>
                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold border {{ $statusColor }}">
                                {{ $orderLabel }}
                            </span>
                        </div>

                        <div class="text-sm text-warm-300 mb-2">
                            @foreach($order['items'] as $item)
                                <p>{{ $item['variant_name_snapshot'] }} × {{ $item['quantity'] }}</p>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="font-bold text-white">Rp {{ number_format($order['grand_total'], 0, ',', '.') }}</span>
                            <div class="flex gap-2">
                                @if($order['status'] === 'PENDING_PAYMENT')
                                    <button wire:click="verifyPayment('{{ $order['id'] }}')"
                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-green-500 text-white hover:bg-green-600 transition-colors">
                                        Verifikasi Bayar
                                    </button>
                                    <button wire:click="markPreparing('{{ $order['id'] }}')"
                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500 text-white hover:bg-blue-600 transition-colors">
                                        Proses
                                    </button>
                                @endif
                                @if($order['status'] === 'PREPARING')
                                    <button wire:click="markReady('{{ $order['id'] }}')"
                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-green-500 text-white hover:bg-green-600 transition-colors">
                                        Siap
                                    </button>
                                @endif
                                @if($order['status'] === 'READY')
                                    <button wire:click="markCompleted('{{ $order['id'] }}')"
                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-accent text-white hover:bg-accent-500 transition-colors">
                                        Selesai
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</div>
