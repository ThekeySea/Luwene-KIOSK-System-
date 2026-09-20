<div class="min-h-dvh bg-warm-50 pb-32">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3 flex items-center gap-3">
            <button type="button" onclick="history.back()" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <h1 class="text-sm font-bold text-dark">Keranjang</h1>
        </div>
    </header>

    <main class="max-w-lg mx-auto px-4 py-4">
        @if (empty($items))
            <div class="text-center py-16">
                <p class="text-4xl mb-3">🛒</p>
                <p class="text-warm-500 text-sm">Keranjang masih kosong</p>
                <a href="{{ $branchId ? route('delivery.branch', $branchId) : route('delivery.home') }}" class="inline-block mt-3 px-6 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-700 transition">Pesan Sekarang</a>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($items as $item)
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-dark text-sm">{{ $item['product_name'] }}</h3>
                                @if($item['variant'])
                                    <p class="text-xs text-warm-500 mt-0.5">{{ $item['variant']['name'] }}</p>
                                @endif
                                @if(!empty($item['modifiers']))
                                    <p class="text-xs text-warm-400 mt-0.5">
                                        @foreach($item['modifiers'] as $mod)
                                            {{ $mod['name'] }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </p>
                                @endif
                            </div>
                            <button wire:click="removeItem(@js($item['id']))" class="text-warm-400 hover:text-red-500 transition shrink-0 ml-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center gap-3">
                                <button wire:click="updateQuantity(@js($item['id']), -1)" class="w-8 h-8 bg-warm-100 rounded-lg flex items-center justify-center text-dark font-bold hover:bg-warm-200 transition text-sm">-</button>
                                <span class="text-sm font-bold text-dark w-6 text-center">{{ $item['quantity'] }}</span>
                                <button wire:click="updateQuantity(@js($item['id']), 1)" class="w-8 h-8 bg-warm-100 rounded-lg flex items-center justify-center text-dark font-bold hover:bg-warm-200 transition text-sm">+</button>
                            </div>
                            <p class="text-sm font-bold text-primary">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100 mt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-warm-500">Subtotal</span>
                    <span class="text-dark font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-warm-500">Ongkir</span>
                    @if($deliveryFee > 0)
                        <span class="text-dark font-medium">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                    @else
                        <span class="text-green-600 font-medium">Gratis</span>
                    @endif
                </div>
                <div class="flex justify-between text-lg font-bold pt-2 border-t border-warm-100">
                    <span class="text-dark">Total</span>
                    <span class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        @endif
    </main>

    @if(!empty($items))
        <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-warm-100 z-20">
            <div class="max-w-lg mx-auto">
                <a href="{{ route('delivery.checkout') }}" class="flex items-center justify-between bg-primary text-white px-5 py-3.5 rounded-2xl shadow-lg hover:bg-primary-700 transition">
                    <div>
                        <p class="text-xs opacity-80">{{ count($items) }} item &middot; Ongkir Rp {{ number_format($deliveryFee, 0, ',', '.') }}</p>
                        <p class="text-lg font-bold">Rp {{ number_format($total, 0, ',', '.') }}</p>
                    </div>
                    <span class="text-sm font-semibold">Checkout →</span>
                </a>
            </div>
        </div>
    @endif
</div>
