@php
    $cart = session('cart', []);
    $cartCount = count($cart);
    $orderMode = session('order_mode');
    $tableName = session('table_name');
@endphp

<div>
    <x-navbar :cartCount="$cartCount" :orderMode="$orderMode" :tableName="$tableName" />

    <div class="pb-24">
        <div class="sticky top-14 z-40 bg-dark-800/95 backdrop-blur-xl border-b border-dark-700">
            <div class="px-4 py-3">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari menu..."
                       class="w-full px-4 py-2.5 bg-dark-700 border border-dark-600 rounded-xl text-sm text-warm-100 placeholder-warm-500 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent/50">
            </div>
            <div class="flex gap-2 px-4 pb-3 overflow-x-auto scrollbar-hide">
                <button wire:click="selectCategory(null)"
                        class="shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold transition-all
                        {{ !$selectedCategory ? 'bg-accent text-white shadow-lg shadow-accent/20' : 'bg-dark-700 text-warm-400 hover:bg-dark-600 border border-dark-600' }}">
                    Semua
                </button>
                @foreach($categories as $cat)
                    <button wire:click="selectCategory('{{ $cat['slug'] }}')"
                            class="shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold transition-all
                            {{ $selectedCategory === $cat['slug'] ? 'bg-accent text-white shadow-lg shadow-accent/20' : 'bg-dark-700 text-warm-400 hover:bg-dark-600 border border-dark-600' }}">
                        {{ $cat['name'] }}
                    </button>
                @endforeach
            </div>
        </div>

        @if(!$selectedCategory && !$search && count($packages) > 0)
            <div class="px-4 pt-4">
                <h2 class="text-lg font-bold text-white mb-3">Paket LUWENE</h2>
                <div class="flex gap-3 overflow-x-auto pb-4 scrollbar-hide">
                    @foreach($packages as $pkg)
                        <div class="shrink-0 w-56 bg-dark-800 rounded-2xl border border-dark-700 p-4">
                            <div class="w-full h-28 bg-gradient-to-br from-accent/20 to-primary/10 rounded-xl mb-3 flex items-center justify-center">
                                <span class="text-3xl">🍱</span>
                            </div>
                            <h3 class="font-bold text-sm text-white">{{ $pkg['name'] }}</h3>
                            <p class="text-xs text-warm-400 mt-1 line-clamp-2">{{ $pkg['description'] }}</p>
                            <p class="text-accent font-bold text-sm mt-2">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="px-4 pt-2">
            @if(!$selectedCategory && !$search)
                <h2 class="text-lg font-bold text-white mb-3">Menu</h2>
            @endif

            @if(count($products) === 0)
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-dark-800 mb-4">
                        <span class="text-4xl">🍽️</span>
                    </div>
                    <p class="text-warm-500 text-sm">Menu tidak ditemukan</p>
                </div>
            @else
                <div class="grid grid-cols-2 gap-3">
                    @foreach($products as $product)
                        <button wire:click="viewProduct('{{ $product['slug'] }}')"
                                class="bg-dark-800 rounded-2xl border border-dark-700 overflow-hidden text-left active:scale-[0.97] transition-all hover:border-dark-600
                                {{ !$product['is_available'] ? 'opacity-40' : '' }}"
                                {{ !$product['is_available'] ? 'disabled' : '' }}>
                            <div class="w-full aspect-square bg-gradient-to-br from-dark-700 to-dark-800 flex items-center justify-center">
                                @if($product['image_url'])
                                    <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl">🍽️</span>
                                @endif
                            </div>
                            <div class="p-3">
                                @if($product['is_featured'])
                                    <span class="inline-block text-[10px] px-2 py-0.5 bg-accent/15 text-accent rounded-full font-semibold mb-1">Favorit</span>
                                @endif
                                <h3 class="font-semibold text-xs text-white leading-tight">{{ $product['name'] }}</h3>
                                <p class="text-xs text-warm-500 mt-1">{{ $product['category']['name'] ?? '' }}</p>
                                <div class="mt-2">
                                    @if(count($product['variants']) > 0)
                                        <p class="text-accent font-bold text-sm">Rp {{ number_format($product['variants'][0]['price'], 0, ',', '.') }}</p>
                                        @if(count($product['variants']) > 1)
                                            <p class="text-[10px] text-warm-500">Mulai dari</p>
                                        @endif
                                    @else
                                        <p class="text-accent font-bold text-sm">Rp {{ number_format($product['base_price'], 0, ',', '.') }}</p>
                                    @endif
                                </div>
                                @if(!$product['is_available'])
                                    <span class="inline-block mt-1 text-[10px] px-2 py-0.5 bg-primary-500/15 text-primary-400 rounded-full font-semibold">Habis</span>
                                @endif
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
