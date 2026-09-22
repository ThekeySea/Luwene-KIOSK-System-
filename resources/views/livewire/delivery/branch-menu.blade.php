<div class="min-h-dvh bg-warm-50 pb-24">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('delivery.home') }}" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="flex-1 min-w-0">
                    <h1 class="text-sm font-bold text-dark truncate">{{ $branch->name }}</h1>
                    <p class="text-[10px] text-warm-400 truncate">{{ $branch->address }}</p>
                </div>
            </div>
        </div>

        <div class="max-w-lg mx-auto overflow-x-auto scrollbar-hide border-t border-warm-100">
            <div class="flex gap-0 px-4 py-2 min-w-max">
                <button wire:click="setCategory(null)"
                    class="px-4 py-1.5 rounded-full text-xs font-medium transition whitespace-nowrap
                    {{ $activeCategory === null ? 'bg-primary text-white' : 'bg-warm-100 text-warm-600 hover:bg-warm-200' }}">
                    Semua
                </button>
                @foreach ($categories as $cat)
                    <button wire:click="setCategory('{{ $cat->slug }}')"
                        class="px-4 py-1.5 rounded-full text-xs font-medium transition whitespace-nowrap
                        {{ $activeCategory === $cat->slug ? 'bg-primary text-white' : 'bg-warm-100 text-warm-600 hover:bg-warm-200' }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </header>

    <main class="max-w-lg mx-auto px-4 py-4">
        @if ($products->isEmpty())
            <div class="text-center py-16">
                <p class="text-4xl mb-3">🍽️</p>
                <p class="text-warm-500 text-sm">Tidak ada menu tersedia</p>
            </div>
        @else
            <div class="grid grid-cols-2 gap-3">
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
                        <div class="aspect-[4/3] bg-warm-100 flex items-center justify-center relative">
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

    @if($cartCount > 0)
        <div class="fixed bottom-0 left-0 right-0 p-4 z-20">
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
