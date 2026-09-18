<div>
    <x-navbar :cartCount="0" />

    <div class="min-h-dvh pb-24" {{ $polling ? 'wire:poll.3s=pollStatus' : '' }}>
        @if($order)
            <div class="px-4 pt-4">
                <div class="text-center mb-8">
                    @if($order['status'] === 'COMPLETED')
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-500/10 mb-4">
                            <span class="text-4xl">🎉</span>
                        </div>
                        <h1 class="text-xl font-bold text-green-400">Pesanan Selesai!</h1>
                    @elseif($order['status'] === 'CANCELLED')
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-500/10 mb-4">
                            <span class="text-4xl">😔</span>
                        </div>
                        <h1 class="text-xl font-bold text-primary-400">Pesanan Dibatalkan</h1>
                    @else
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent/10 mb-4 animate-pulse">
                            <span class="text-4xl">⏳</span>
                        </div>
                        <h1 class="text-xl font-bold text-white">Pesanan Sedang Diproses</h1>
                    @endif

                    <div class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-dark-800 border border-dark-700 rounded-full">
                        <span class="text-sm font-mono font-bold text-accent">#{{ $order['order_number'] }}</span>
                    </div>
                    @if($order['table_number'])
                        <p class="text-sm text-warm-500 mt-1">Meja {{ $order['table_number'] }}</p>
                    @endif
                </div>

                <div class="bg-dark-800 rounded-2xl border border-dark-700 p-5 mb-4">
                    <h3 class="text-sm font-bold text-white mb-4 uppercase tracking-wider">Status Pesanan</h3>
                    <div class="space-y-4">
                        @foreach($this->getStatusSteps() as $step)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0
                                    {{ $step['status'] === 'completed' ? 'bg-green-500/20' : ($step['status'] === 'current' ? 'bg-accent/20 animate-pulse' : 'bg-dark-700') }}">
                                    @if($step['status'] === 'completed')
                                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        <span class="text-sm">{{ $step['icon'] }}</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm {{ $step['status'] === 'current' ? 'font-bold text-accent' : ($step['status'] === 'completed' ? 'text-warm-500 line-through' : 'text-warm-500') }}">
                                        {{ $step['label'] }}
                                    </p>
                                </div>
                                @if($step['status'] === 'current')
                                    <span class="text-xs px-2 py-0.5 bg-accent/15 text-accent rounded-full font-semibold">Saat ini</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-dark-800 rounded-2xl border border-dark-700 p-4 mb-4">
                    <h3 class="text-sm font-bold text-white mb-3 uppercase tracking-wider">Detail Pesanan</h3>
                    <div class="space-y-2">
                        @foreach($order['items'] as $item)
                            <div class="flex justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-warm-200">{{ $item['product_name_snapshot'] }}</p>
                                    <p class="text-xs text-warm-500">
                                        {{ $item['variant_name_snapshot'] }}
                                        @if(count($item['modifiers']) > 0)
                                            • {{ implode(', ', array_map(fn($m) => $m['name_snapshot'], $item['modifiers'])) }}
                                        @endif
                                    </p>
                                    <p class="text-xs text-warm-500">{{ $item['quantity'] }}x</p>
                                </div>
                                <p class="text-sm font-semibold text-warm-200">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-dark-600 mt-3 pt-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-warm-400">Subtotal</span>
                            <span class="text-sm text-warm-200">Rp {{ number_format($order['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        @if($order['tax_amount'] > 0)
                            <div class="flex justify-between">
                                <span class="text-sm text-warm-400">Pajak</span>
                                <span class="text-sm text-warm-200">Rp {{ number_format($order['tax_amount'], 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between mt-2 pt-2 border-t border-dark-600">
                            <span class="font-bold text-white">Total</span>
                            <span class="font-bold text-accent">Rp {{ number_format($order['grand_total'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                @if($order['payment'])
                    <div class="bg-dark-800 rounded-2xl border border-dark-700 p-4 mb-4">
                        <h3 class="text-sm font-bold text-white mb-2 uppercase tracking-wider">Pembayaran</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-warm-400">{{ $order['payment']['payment_method'] }}</span>
                            <span class="text-sm font-semibold px-2 py-0.5 rounded-full
                                {{ $order['payment']['status'] === 'PAID' ? 'bg-green-500/15 text-green-400' : 'bg-yellow-500/15 text-yellow-400' }}">
                                {{ $order['payment']['status'] === 'PAID' ? 'Lunas' : 'Menunggu' }}
                            </span>
                        </div>
                    </div>
                @endif

                <div class="text-center mt-6">
                    <a href="{{ route('customer.menu') }}" class="text-accent text-sm font-semibold">← Kembali ke Menu</a>
                </div>
            </div>
        @else
            <div class="flex items-center justify-center min-h-dvh">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-dark-800 mb-4 animate-pulse">
                        <span class="text-3xl">🔍</span>
                    </div>
                    <p class="text-warm-500 text-sm">Memuat pesanan...</p>
                </div>
            </div>
        @endif
    </div>
</div>
