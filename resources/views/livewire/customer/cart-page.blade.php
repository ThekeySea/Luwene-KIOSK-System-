@php
    $cartData = session('cart', []);
    $cartCount = count($cartData);
    $orderMode = session('order_mode');
    $tableName = session('table_name');
@endphp

<div>
    <x-navbar :cartCount="$cartCount" :orderMode="$orderMode" :tableName="$tableName" />

    <div class="pb-24">
        <div class="px-4 pt-4">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('customer.menu') }}" class="w-10 h-10 bg-dark-800 rounded-full flex items-center justify-center border border-dark-700">
                    <svg class="w-5 h-5 text-warm-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-white">Keranjang</h1>
            </div>

            @if($orderMode)
                <div class="mb-4 p-3 bg-dark-800 border border-dark-700 rounded-xl flex items-center gap-3">
                    <span class="text-lg">{{ $orderMode === 'DINE_IN' ? '🍽️' : '🥡' }}</span>
                    <div>
                        <p class="text-xs text-warm-500">{{ $orderMode === 'DINE_IN' ? 'Dine In' : 'Take Away' }}</p>
                        <p class="text-sm font-semibold text-warm-100">{{ $orderMode === 'DINE_IN' ? 'Meja ' . $tableName : 'Ambil di kasir' }}</p>
                    </div>
                </div>
            @endif

            @if(empty($cartData))
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-dark-800 mb-4">
                        <span class="text-4xl">🛒</span>
                    </div>
                    <p class="text-warm-500 text-sm">Keranjang kosong</p>
                    <a href="{{ route('customer.menu') }}" class="mt-4 inline-block text-accent text-sm font-semibold">Pesan Sekarang</a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($cartData as $item)
                        <div class="bg-dark-800 rounded-2xl border border-dark-700 p-4">
                            <div class="flex gap-3">
                                <div class="w-14 h-14 bg-dark-700 rounded-xl shrink-0 flex items-center justify-center">
                                    <span class="text-2xl">🍽️</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <div class="min-w-0">
                                            <h3 class="font-semibold text-sm text-white truncate">{{ $item['product_name'] }}</h3>
                                            <p class="text-xs text-accent mt-0.5">{{ $item['variant_name'] }}</p>
                                        </div>
                                        <button wire:click="removeItem('{{ $item['id'] }}')" class="text-warm-600 hover:text-primary-400 shrink-0 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>

                                    @if(count($item['modifiers']) > 0)
                                        <div class="mt-1.5 flex flex-wrap gap-1">
                                            @foreach($item['modifiers'] as $mod)
                                                <span class="text-[10px] px-1.5 py-0.5 bg-dark-700 text-warm-400 rounded">{{ $mod['name'] }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between mt-3">
                                        <div class="flex items-center gap-2">
                                            <button wire:click="updateQuantity('{{ $item['id'] }}', -1)"
                                                    class="w-7 h-7 rounded-lg border border-dark-600 bg-dark-700 flex items-center justify-center text-sm text-warm-300 hover:border-dark-500">−</button>
                                            <span class="text-sm font-semibold w-6 text-center text-white">{{ $item['quantity'] }}</span>
                                            <button wire:click="updateQuantity('{{ $item['id'] }}', 1)"
                                                    class="w-7 h-7 rounded-lg border border-dark-600 bg-dark-700 flex items-center justify-center text-sm text-warm-300 hover:border-dark-500">+</button>
                                        </div>
                                        <p class="text-sm font-bold text-accent">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 p-4 bg-dark-800 rounded-2xl border border-dark-700">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-warm-400">Subtotal</span>
                        <span class="text-lg font-bold text-white">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endif
        </div>

        @if(!empty($cartData))
            <div class="fixed bottom-0 left-0 right-0 bg-dark-800/95 backdrop-blur-xl border-t border-dark-700 p-4 z-50">
                <div class="max-w-lg mx-auto">
                    <button wire:click="goToCheckout"
                            class="w-full bg-accent hover:bg-accent-500 text-white py-3.5 rounded-xl font-bold text-sm active:scale-[0.98] transition-all shadow-lg shadow-accent/20">
                        Checkout • Rp {{ number_format($this->subtotal, 0, ',', '.') }}
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
