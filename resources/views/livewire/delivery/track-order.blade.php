<div class="min-h-dvh bg-warm-50 pb-32">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3 flex items-center gap-3">
            <a href="{{ route('delivery.orders') }}" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-line-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-sm font-bold text-dark">Lacak Pesanan</h1>
                <p class="text-[11px] text-warm-400">#{{ $order->order_number }}</p>
            </div>
        </div>
    </header>

    <main class="max-w-lg mx-auto px-4 py-4 space-y-4">

        {{-- Status Banner --}}
        @if($order->status === 'CANCELLED')
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-center">
                <p class="text-2xl mb-1">❌</p>
                <p class="text-sm font-bold text-red-700">Pesanan Dibatalkan</p>
            </div>
        @elseif($order->status === 'DELIVERED')
            <div class="bg-green-50 border border-green-200 rounded-2xl p-4 text-center">
                <p class="text-2xl mb-1">🎉</p>
                <p class="text-sm font-bold text-green-700">Pesanan Sudah Tiba!</p>
                <p class="text-xs text-green-600 mt-1">Selamat menikmati</p>
            </div>
        @elseif($order->status === 'OUT_FOR_DELIVERY' && $estMinutes !== null && $estMinutes > 0)
            <div class="bg-primary/5 border border-primary/20 rounded-2xl p-4 text-center">
                <p class="text-2xl mb-1">🛵</p>
                <p class="text-sm font-bold text-primary">Sedang Dalam Perjalanan</p>
                <p class="text-xs text-warm-500 mt-1">Estimasi tiba {{ $estMinutes }} menit lagi</p>
            </div>
        @endif

        {{-- Timeline --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
            <h3 class="text-xs font-semibold text-warm-400 uppercase tracking-wide mb-4">Status Pesanan</h3>
            <div class="space-y-0">
                @foreach($statusSteps as $step)
                    @continue($order->status === 'CANCELLED' && $step['key'] !== 'PENDING')
                    <div class="flex items-start gap-3 relative">
                        {{-- Line --}}
                        @if(! $loop->last)
                            <div class="absolute left-[15px] top-[28px] w-0.5 h-full
                                {{ $step['state'] === 'completed' ? 'bg-primary' : 'bg-warm-100' }}"></div>
                        @endif

                        {{-- Circle --}}
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 z-10 text-sm
                            {{ $step['state'] === 'completed' ? 'bg-primary text-white' :
                               ($step['state'] === 'current' ? 'bg-primary/10 text-primary ring-2 ring-primary/30 animate-pulse' :
                               'bg-warm-100 text-warm-300') }}">
                            @if($step['state'] === 'completed')
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                {{ $step['icon'] }}
                            @endif
                        </div>

                        {{-- Label --}}
                        <div class="pb-6 pt-1">
                            <p class="text-sm font-medium
                                {{ $step['state'] === 'completed' ? 'text-dark' :
                                   ($step['state'] === 'current' ? 'text-primary font-bold' :
                                   'text-warm-300') }}">
                                {{ $step['label'] }}
                            </p>
                            @if($step['state'] === 'current' && $order->status !== 'OUT_FOR_DELIVERY')
                                <p class="text-[11px] text-warm-400 mt-0.5">Sedang diproses...</p>
                            @endif
                        </div>
                    </div>
                @endforeach

                @if($order->status === 'CANCELLED')
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 z-10 text-sm bg-red-100 text-red-500">
                            ✕
                        </div>
                        <div class="pb-2 pt-1">
                            <p class="text-sm font-medium text-red-600">Dibatalkan</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Driver Info --}}
        @if($order->driver_name)
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
                <h3 class="text-xs font-semibold text-warm-400 uppercase tracking-wide mb-3">Driver</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                        <span class="text-lg">🛵</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-dark">{{ $order->driver_name }}</p>
                        @if($order->driver_phone)
                            <p class="text-xs text-warm-400">{{ $order->driver_phone }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- Order Details --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
            <h3 class="text-xs font-semibold text-warm-400 uppercase tracking-wide mb-3">Detail Pesanan</h3>

            {{-- Branch --}}
            @if($order->branch)
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs text-warm-400">Dari</span>
                    <span class="text-xs font-semibold text-dark">{{ $order->branch->name }}</span>
                </div>
            @endif

            {{-- Address --}}
            <div class="flex items-start gap-2 mb-3">
                <span class="text-xs text-warm-400 shrink-0 mt-0.5">📍</span>
                <p class="text-xs text-dark">{{ $order->delivery_address }}</p>
            </div>

            {{-- Items --}}
            <div class="border-t border-warm-100 pt-3 space-y-1.5">
                @foreach($order->items as $item)
                    <div class="flex justify-between items-start gap-3">
                        <p class="text-sm text-dark">{{ $item->quantity }}x {{ $item->product_name }}</p>
                        <span class="text-sm font-medium text-dark shrink-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Totals --}}
            <div class="border-t border-warm-100 mt-3 pt-3 space-y-1.5">
                <div class="flex justify-between text-sm">
                    <span class="text-warm-500">Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-warm-500">Ongkir</span>
                    @if($order->delivery_fee > 0)
                        <span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                    @else
                        <span class="text-green-600 font-medium">Gratis</span>
                    @endif
                </div>
                <div class="flex justify-between text-lg font-bold pt-2 border-t border-warm-100">
                    <span>Total</span>
                    <span class="text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Notes --}}
            @if($order->delivery_notes)
                <div class="mt-3 pt-3 border-t border-warm-100">
                    <p class="text-xs text-warm-400">Catatan:</p>
                    <p class="text-sm text-dark mt-0.5">{{ $order->delivery_notes }}</p>
                </div>
            @endif
        </div>

        {{-- Time info --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100 text-center">
            <p class="text-xs text-warm-400">Dipesan pada</p>
            <p class="text-sm font-medium text-dark mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
            @if($order->delivery_estimated_at)
                <p class="text-xs text-warm-400 mt-2">Estimasi tiba</p>
                <p class="text-sm font-medium text-primary mt-0.5">{{ $order->delivery_estimated_at->format('H:i') }}</p>
            @endif
            <a href="{{ route('delivery.receipt', $order->id) }}" class="inline-block mt-3 text-xs font-semibold text-primary hover:underline">Unduh Struk PDF ↓</a>
        </div>
    </main>

    {{-- Floating Button --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-xl border-t border-warm-100 z-30 safe-bottom">
        <div class="max-w-lg mx-auto px-4 py-3">
            <a href="{{ route('delivery.home') }}"
                class="block w-full py-3.5 rounded-xl font-bold text-white text-sm tracking-wide text-center bg-primary hover:bg-red-800 active:scale-[0.98] transition">
                Pesan Lagi
            </a>
        </div>
    </div>
</div>
