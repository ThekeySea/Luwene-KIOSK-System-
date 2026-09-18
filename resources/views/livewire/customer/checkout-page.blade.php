@php
    $orderMode = session('order_mode');
    $tableName = session('table_name');
@endphp

<div>
    <x-navbar :cartCount="0" :orderMode="$orderMode" :tableName="$tableName" />

    <div class="pb-24">
        <div class="px-4 pt-4">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('customer.cart') }}" class="w-10 h-10 bg-dark-800 rounded-full flex items-center justify-center border border-dark-700">
                    <svg class="w-5 h-5 text-warm-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-white">Checkout</h1>
            </div>

            @if($error)
                <div class="mb-4 p-4 bg-primary-500/10 border border-primary-500/20 rounded-xl text-sm text-primary-300">
                    {{ $error }}
                </div>
            @endif

            <div class="mb-4 p-4 bg-dark-800 border border-dark-700 rounded-xl">
                <div class="flex items-center gap-3">
                    <span class="text-lg">{{ $orderMode === 'DINE_IN' ? '🍽️' : '🥡' }}</span>
                    <div>
                        <p class="text-xs text-warm-500">{{ $orderMode === 'DINE_IN' ? 'Dine In' : 'Take Away' }}</p>
                        <p class="text-sm font-semibold text-warm-100">{{ $orderMode === 'DINE_IN' ? 'Meja ' . $tableName : 'Ambil di kasir' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-dark-800 rounded-2xl border border-dark-700 p-4 mb-4">
                <h3 class="text-sm font-bold text-white mb-3 uppercase tracking-wider">Pesanan</h3>
                <div class="space-y-3">
                    @foreach($cart as $item)
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-warm-100 truncate">{{ $item['product_name'] }}</p>
                                <p class="text-xs text-accent">{{ $item['variant_name'] }}</p>
                                @if(count($item['modifiers']) > 0)
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        @foreach($item['modifiers'] as $mod)
                                            <span class="text-[10px] px-1.5 py-0.5 bg-dark-700 text-warm-400 rounded">{{ $mod['name'] }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                <p class="text-xs text-warm-500 mt-1">{{ $item['quantity'] }}x Rp {{ number_format($item['unit_price'], 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-semibold text-warm-200 ml-3">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-dark-800 rounded-2xl border border-dark-700 p-4 mb-4">
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-warm-400">Subtotal</span>
                        <span class="text-warm-200">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-warm-400">Pajak (10%)</span>
                        <span class="text-warm-200">Rp {{ number_format($this->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-dark-600 pt-2 flex justify-between">
                        <span class="font-bold text-white">Total</span>
                        <span class="text-lg font-bold text-accent">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-dark-800 rounded-2xl border border-dark-700 p-4 mb-6">
                <h3 class="text-sm font-bold text-white mb-3 uppercase tracking-wider">Metode Pembayaran</h3>
                <div class="space-y-2">
                    <button wire:click="selectPayment('CASH')"
                            class="w-full p-4 rounded-xl border-2 text-left flex items-center gap-3 transition-all
                            {{ $paymentMethod === 'CASH' ? 'border-accent bg-accent/10' : 'border-dark-600 bg-dark-700 hover:border-dark-500' }}">
                        <span class="text-2xl">💵</span>
                        <div>
                            <p class="font-semibold text-sm text-white">Cash</p>
                            <p class="text-xs text-warm-400">Bayar tunai di kasir</p>
                        </div>
                    </button>
                    <button wire:click="selectPayment('QRIS')"
                            class="w-full p-4 rounded-xl border-2 text-left flex items-center gap-3 transition-all
                            {{ $paymentMethod === 'QRIS' ? 'border-accent bg-accent/10' : 'border-dark-600 bg-dark-700 hover:border-dark-500' }}">
                        <span class="text-2xl">📱</span>
                        <div>
                            <p class="font-semibold text-sm text-white">QRIS</p>
                            <p class="text-xs text-warm-400">Scan QR untuk bayar</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-dark-800/95 backdrop-blur-xl border-t border-dark-700 p-4 z-50">
            <div class="max-w-lg mx-auto">
                <button wire:click="placeOrder"
                        class="w-full bg-accent hover:bg-accent-500 text-white py-3.5 rounded-xl font-bold text-sm active:scale-[0.98] transition-all shadow-lg shadow-accent/20
                        {{ $processing ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $processing ? 'disabled' : '' }}>
                    @if($processing)
                        <span class="flex items-center justify-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Memproses...
                        </span>
                    @else
                        Bayar • Rp {{ number_format($this->total, 0, ',', '.') }}
                    @endif
                </button>
            </div>
        </div>
    </div>
</div>
