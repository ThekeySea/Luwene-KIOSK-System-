    <div class="min-h-dvh bg-warm-50">
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
                <a href="{{ route('customer.dashboard') }}" class="text-warm-400 hover:text-dark transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-lg font-display font-bold text-dark">Pesanan</h1>
                <div class="w-6"></div>
            </div>
        </header>

        <div class="max-w-3xl mx-auto p-4">
            <div class="text-center mb-6">
                <p class="text-sm text-warm-400">Nomor Pesanan</p>
                <p class="text-2xl font-display font-bold text-dark">#{{ $order->order_number }}</p>
                @if($order->table)
                    <p class="text-sm text-warm-500 mt-1">Meja {{ $order->table->table_number }}</p>
                @endif
            </div>

            @if ($order->status === 'CANCELLED')
                <div class="bg-red-50 rounded-2xl p-6 text-center mb-6">
                    <span class="text-4xl">❌</span>
                    <p class="text-lg font-bold text-red-600 mt-2">Pesanan Dibatalkan</p>
                </div>
            @else
                <div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
                    <div class="space-y-4">
                        @foreach ($statusSteps as $step)
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg flex-shrink-0
                                    @if($step['status'] === 'completed') bg-green-100
                                    @elseif($step['status'] === 'current') bg-primary/10 ring-2 ring-primary ring-offset-2
                                    @else bg-warm-100 @endif">
                                    @if($step['status'] === 'completed')
                                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        {{ $step['icon'] }}
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium
                                        @if($step['status'] === 'completed') text-green-600
                                        @elseif($step['status'] === 'current') text-primary font-bold
                                        @else text-warm-400 @endif">
                                        {{ $step['label'] }}
                                    </p>
                                </div>
                                @if($step['status'] === 'current')
                                    <span class="animate-pulse w-2 h-2 bg-primary rounded-full"></span>
                                @endif
                            </div>
                            @if(!$loop->last)
                                <div class="ml-5 border-l-2 border-dashed
                                    @if($step['status'] === 'completed') border-green-300
                                    @else border-warm-200 @endif h-4"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl p-4 shadow-sm mb-6">
                <h2 class="font-semibold text-dark mb-3">Detail Pesanan</h2>
                <div class="space-y-2">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-dark">{{ $item->quantity }}x {{ $item->product_name }}</p>
                                @if($item->variant_name)
                                    <p class="text-xs text-warm-400">{{ $item->variant_name }}</p>
                                @endif
                                @if($item->modifiers->count() > 0)
                                    <p class="text-xs text-warm-400">
                                        @foreach($item->modifiers as $mod)
                                            {{ $mod->modifier_name }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </p>
                                @endif
                            </div>
                            <p class="text-sm font-medium text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3 pt-3 border-t border-warm-100 space-y-1">
                    <div class="flex justify-between text-sm">
                        <span class="text-warm-500">Subtotal</span>
                        <span class="text-dark">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-warm-500">Pajak (11%)</span>
                        <span class="text-dark">Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-2 border-t border-warm-100">
                        <span class="text-dark">Total</span>
                        <span class="text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm">
                <h2 class="font-semibold text-dark mb-2">Pembayaran</h2>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-warm-500">{{ $order->payment->method ?? '-' }}</span>
                    <span class="inline-block text-xs px-2 py-0.5 rounded-full font-medium
                        @if($order->payment_status === 'PAID') bg-green-100 text-green-700
                        @elseif($order->payment_status === 'UNPAID') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ $order->payment_status }}
                    </span>
                </div>
            </div>
        </div>
    </div>
