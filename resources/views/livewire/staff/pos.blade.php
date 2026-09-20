<div class="min-h-[calc(100dvh-64px)]">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('cashier.dashboard') }}" class="text-gray-400 hover:text-gray-900 transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-lg font-display font-bold text-gray-900">POS</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('cashier.scan') }}" class="text-sm font-medium text-primary hover:text-primary-700 transition">Scan</a>
                <span class="text-sm text-gray-500">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden" wire:poll.5s>
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-display font-bold text-gray-900">Pesanan Aktif</h2>
                <span class="flex items-center gap-1.5 text-[11px] font-medium text-green-600">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    Live
                </span>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($pendingOrders as $order)
                    <div class="px-5 py-4">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <p class="text-sm font-bold text-gray-900">#{{ $order->order_number }} &middot; {{ $order->customer_name ?? 'Tanpa nama' }}</p>
                                <p class="text-xs text-gray-400">
                                    @if($order->order_mode === 'DINE_IN')
                                        Dine In{{ $order->table ? ' · Meja '.$order->table->table_number : '' }}
                                    @else
                                        Bawa Pulang
                                    @endif
                                    &middot; {{ $order->created_at->format('H:i') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                <span class="inline-block text-xs px-2 py-0.5 rounded-full font-medium
                                    @if($order->status === 'PENDING') bg-yellow-100 text-yellow-700
                                    @elseif($order->status === 'CONFIRMED') bg-blue-100 text-blue-700
                                    @elseif($order->status === 'PREPARING') bg-orange-100 text-orange-700
                                    @else bg-green-100 text-green-700
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            @php($nextLabel = match($order->status) {
                                'PENDING' => 'Konfirmasi',
                                'CONFIRMED' => 'Mulai Siapkan',
                                'PREPARING' => 'Tandai Siap',
                                'READY' => 'Selesaikan',
                                default => null,
                            })
                            @if($nextLabel)
                                <button
                                    wire:click="advance('{{ $order->id }}')"
                                    wire:loading.attr="disabled"
                                    wire:target="advance('{{ $order->id }}')"
                                    class="px-4 py-2 text-white text-xs font-semibold rounded-lg transition disabled:opacity-50
                                        {{ $order->status === 'PENDING' ? 'bg-blue-500 hover:bg-blue-600' : ($order->status === 'CONFIRMED' ? 'bg-orange-500 hover:bg-orange-600' : 'bg-green-500 hover:bg-green-600') }}">
                                    <span wire:loading.remove wire:target="advance('{{ $order->id }}')">{{ $nextLabel }}</span>
                                    <span wire:loading wire:target="advance('{{ $order->id }}')">Memproses...</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-12 text-center text-gray-400 text-sm">Tidak ada pesanan aktif</div>
                @endforelse
            </div>
        </div>
    </main>
</div>
