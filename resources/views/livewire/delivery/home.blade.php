<div class="min-h-dvh bg-warm-50 pb-24 md:pb-0">
    <form id="delivery-logout-form" method="POST" action="{{ route('delivery.logout') }}" class="hidden">
        @csrf
    </form>

    {{-- Header --}}
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-6xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <button type="button" onclick="document.getElementById('delivery-logout-form').submit()" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-warm-100 text-warm-500 hover:text-dark transition shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <span class="text-xl">🛵</span>
                    <div>
                        <p class="text-sm font-bold text-dark">LUWENE Benowo</p>
                        <p class="text-[10px] text-warm-400">Ongkir Rp {{ number_format($deliveryFee, 0, ',', '.') }} · {{ $estMinutes }} min</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ route('delivery.cart') }}" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-warm-100 text-warm-500 transition relative">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('delivery.profile') }}" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-warm-100 text-warm-500 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-warm-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" class="w-full bg-warm-100 rounded-xl pl-9 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-primary focus:bg-white transition" placeholder="Cari menu...">
            </div>
        </div>

        @if($categories->isNotEmpty())
            <div class="max-w-6xl mx-auto overflow-x-auto scrollbar-hide border-t border-warm-100">
                <div class="flex gap-2 px-4 py-2 min-w-max">
                    @foreach ($categories as $cat)
                        @php
                            $catSlug = $cat->slug;
                            $icon = match($catSlug) {
                                'ayam' => '🍗',
                                'daging' => '🥩',
                                'seafood' => '🦐',
                                'sambal' => '🌶️',
                                'cemal-cemil' => '🍟',
                                'minuman' => '🥤',
                                default => '🍽️',
                            };
                        @endphp
                        <button type="button" wire:click="toggleCategory('{{ $cat->id }}')"
                            class="px-3 py-1.5 text-xs font-medium whitespace-nowrap rounded-full border transition
                            {{ $selectedCategory === $cat->id
                                ? 'bg-primary text-white border-primary shadow-sm'
                                : 'text-warm-600 border-warm-200 bg-white hover:bg-warm-100' }}">
                            {{ $icon }} {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </header>

    {{-- Main Content --}}
    <div class="max-w-6xl mx-auto px-4 py-4 flex gap-6">
        {{-- Menu Grid --}}
        <main class="flex-1 min-w-0">
            @if ($products->isEmpty())
                <div class="text-center py-16">
                    <p class="text-4xl mb-3">🍽️</p>
                    <p class="text-warm-500 text-sm">
                        @if($search)
                            Tidak ada menu untuk "{{ $search }}"
                        @else
                            Menu belum tersedia
                        @endif
                    </p>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach ($products as $product)
                        @php
                            $catSlug = $product->category->slug ?? '';
                            $icon = match($catSlug) {
                                'ayam' => '🍗',
                                'daging' => '🥩',
                                'seafood' => '🦐',
                                'sambal' => '🌶️',
                                'cemal-cemil' => '🍟',
                                'minuman' => '🥤',
                                default => '🍽️',
                            };
                        @endphp
                        <a href="{{ route('delivery.product', $product->slug) }}" class="bg-white rounded-2xl shadow-sm border border-warm-100 overflow-hidden hover:shadow-md transition flex flex-col">
                            <div class="aspect-[4/3] bg-warm-100 flex items-center justify-center relative overflow-hidden">
                                @if($product->image)
                                    <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl">{{ $icon }}</span>
                                @endif
                                @if($product->is_featured)
                                    <span class="absolute top-2 left-2 text-[9px] font-bold uppercase tracking-wide bg-accent text-white px-2 py-0.5 rounded-full shadow">Favorit</span>
                                @endif
                            </div>
                            <div class="p-3 flex flex-col flex-1">
                                <h3 class="font-semibold text-dark text-xs leading-snug line-clamp-2">{{ $product->name }}</h3>
                                @if($product->description)
                                    <p class="text-[10px] text-warm-400 mt-0.5 line-clamp-1">{{ \Illuminate\Support\Str::words($product->description, 5, '...') }}</p>
                                @endif
                                <div class="mt-auto pt-2">
                                    <p class="text-sm font-bold text-primary">Rp {{ number_format($product->base_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </main>

        {{-- Desktop Cart Sidebar --}}
        <aside class="hidden md:block w-80 shrink-0">
            <div class="sticky top-20 space-y-4">
                <div class="bg-white rounded-2xl shadow-sm border border-warm-100 p-4">
                    <h3 class="font-bold text-dark text-sm mb-3">🛒 Keranjang</h3>
                    @if($cartCount > 0)
                        <div class="space-y-3 max-h-80 overflow-y-auto">
                            @foreach($cart as $item)
                                <div class="flex items-start gap-3">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-dark truncate">{{ $item['product_name'] }}</p>
                                        @if($item['variant'])
                                            <p class="text-[10px] text-warm-400">{{ $item['variant']['name'] }}</p>
                                        @endif
                                        <p class="text-[10px] text-warm-400">x{{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="text-xs font-bold text-primary shrink-0">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="border-t border-warm-100 mt-3 pt-3 space-y-1.5">
                            <div class="flex justify-between text-xs">
                                <span class="text-warm-500">Subtotal</span>
                                <span class="text-dark">Rp {{ number_format($cartSubtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-warm-500">Ongkir</span>
                                <span class="text-dark">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm font-bold pt-2 border-t border-warm-100">
                                <span class="text-dark">Total</span>
                                <span class="text-primary">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('delivery.checkout') }}" class="block w-full mt-3 bg-primary text-white text-center text-sm font-semibold py-3 rounded-xl hover:bg-primary/90 transition">
                            Checkout →
                        </a>
                    @else
                        <p class="text-xs text-warm-400 text-center py-4">Keranjang kosong</p>
                    @endif
                </div>
            </div>
        </aside>
    </div>

    {{-- Mobile Cart Bar --}}
    @if($cartCount > 0)
        <div class="fixed bottom-0 left-0 right-0 p-4 z-20 md:hidden">
            <div class="max-w-lg mx-auto">
                <a href="{{ route('delivery.cart') }}" class="flex items-center justify-between bg-primary text-white px-5 py-3.5 rounded-2xl shadow-lg hover:bg-primary-700 transition">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                            </svg>
                        </span>
                        <span class="text-sm font-semibold">{{ $cartCount }} item</span>
                    </div>
                    <span class="text-sm font-bold">Lihat Keranjang →</span>
                </a>
            </div>
        </div>
    @endif
</div>
