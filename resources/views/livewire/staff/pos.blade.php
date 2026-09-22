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
                    @php
                        $isDelivery = $order->order_mode === 'DELIVERY';
                        $borderColor = $isDelivery ? 'border-l-purple-500' : 'border-l-emerald-500';
                        $badgeBg = $isDelivery ? 'bg-purple-100 text-purple-700' : 'bg-emerald-100 text-emerald-700';
                        $badgeIcon = $isDelivery ? '🛵' : match($order->order_mode) {
                            'DINE_IN' => '🍽️',
                            'TAKEAWAY' => '📦',
                            default => '🛒',
                        };
                        $badgeLabel = $isDelivery ? 'Delivery' : match($order->order_mode) {
                            'DINE_IN' => 'Dine In',
                            'TAKEAWAY' => 'Bawa Pulang',
                            default => 'Kiosk',
                        };
                    @endphp
                    <div class="px-5 py-4 border-l-4 {{ $borderColor }}">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wide {{ $badgeBg }} px-2 py-0.5 rounded-full">
                                        {{ $badgeIcon }} {{ $badgeLabel }}
                                    </span>
                                    <p class="text-sm font-bold text-gray-900">#{{ $order->order_number }} &middot; {{ $order->customer_name ?? 'Tanpa nama' }}</p>
                                </div>
                                <p class="text-xs text-gray-400">
                                    @if($order->order_mode === 'DINE_IN')
                                        Meja {{ $order->table->table_number ?? '-' }}
                                    @elseif($order->order_mode === 'DELIVERY' && $order->driver_name)
                                        Driver: {{ $order->driver_name }}
                                    @endif
                                    &middot; {{ $order->created_at->format('H:i') }}
                                </p>
                                @if($order->order_mode === 'DELIVERY' && $order->delivery_address)
                                    <p class="text-xs text-gray-400 mt-0.5">📍 {{ Str::limit($order->delivery_address, 60) }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                <span class="inline-block text-xs px-2 py-0.5 rounded-full font-medium
                                    @if($order->status === 'PENDING') bg-yellow-100 text-yellow-700
                                    @elseif($order->status === 'CONFIRMED') bg-blue-100 text-blue-700
                                    @elseif($order->status === 'PREPARING') bg-orange-100 text-orange-700
                                    @elseif($order->status === 'OUT_FOR_DELIVERY') bg-purple-100 text-purple-700
                                    @else bg-green-100 text-green-700
                                    @endif">
                                    @if($order->status === 'OUT_FOR_DELIVERY') Sedang Dikirim
                                    @else {{ $order->status }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            @php($nextLabel = match($order->status) {
                                'PENDING' => 'Konfirmasi',
                                'CONFIRMED' => 'Mulai Siapkan',
                                'PREPARING' => 'Tandai Siap',
                                'READY' => $order->order_mode === 'DELIVERY' ? 'Kirim' : 'Selesaikan',
                                'OUT_FOR_DELIVERY' => 'Terkirim',
                                default => null,
                            })
                            @if($nextLabel)
                                <button
                                    wire:click="advance('{{ $order->id }}')"
                                    wire:loading.attr="disabled"
                                    wire:target="advance('{{ $order->id }}')"
                                    class="px-4 py-2 text-white text-xs font-semibold rounded-lg transition disabled:opacity-50
                                        @if($order->status === 'PENDING') bg-blue-500 hover:bg-blue-600
                                        @elseif($order->status === 'CONFIRMED') bg-orange-500 hover:bg-orange-600
                                        @elseif($order->status === 'OUT_FOR_DELIVERY') bg-purple-500 hover:bg-purple-600
                                        @else bg-green-500 hover:bg-green-600
                                        @endif">
                                    <span wire:loading.remove wire:target="advance('{{ $order->id }}')">{{ $nextLabel }}</span>
                                    <span wire:loading wire:target="advance('{{ $order->id }}')">Memproses...</span>
                                </button>
                            @endif
                            @if($order->status === 'PENDING')
                                <button
                                    wire:click="openCancelModal('{{ $order->id }}')"
                                    class="px-4 py-2 text-red-600 text-xs font-semibold rounded-lg border border-red-200 hover:bg-red-50 transition">
                                    Batalkan
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

    @if($showDriverModal)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click.self="$set('showDriverModal', false)">
            <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
                <h3 class="text-lg font-bold text-gray-900 mb-1">Data Driver</h3>
                <p class="text-sm text-gray-500 mb-4">Isi data driver untuk pengiriman delivery.</p>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Driver *</label>
                        <input type="text" wire:model="driverName" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Nama driver">
                        @error('driverName') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP Driver</label>
                        <input type="text" wire:model="driverPhone" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary" placeholder="08xxx">
                    </div>
                </div>

                <div class="flex gap-2 mt-5">
                    <button wire:click="$set('showDriverModal', false)" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Batal</button>
                    <button wire:click="confirmAdvanceWithDriver" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-purple-500 text-white text-sm font-semibold rounded-lg hover:bg-purple-600 transition disabled:opacity-50">
                        <span wire:loading.remove>Kirim</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($showCancelModal)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click.self="$set('showCancelModal', false)">
            <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
                <h3 class="text-lg font-bold text-gray-900 mb-1">Batalkan Pesanan?</h3>
                <p class="text-sm text-gray-500 mb-5">Pesanan akan dibatalkan dan meja yang terkait akan dikembalikan ke status kosong.</p>
                <div class="flex gap-2">
                    <button wire:click="$set('showCancelModal', false)" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Kembali</button>
                    <button wire:click="confirmCancel" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-red-500 text-white text-sm font-semibold rounded-lg hover:bg-red-600 transition disabled:opacity-50">
                        <span wire:loading.remove>Ya, Batalkan</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
