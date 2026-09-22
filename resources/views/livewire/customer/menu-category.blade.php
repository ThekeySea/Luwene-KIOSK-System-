<div class="min-h-dvh bg-warm-50 pb-8 md:pt-16">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-3">
            <a href="{{ route('customer.menu') }}" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition" aria-label="Kembali">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-display font-bold text-primary leading-tight">LUWENE</h1>
                <p class="text-xs text-warm-400">
                    @if($orderMode === 'DINE_IN')
                        Dine In &middot; Meja {{ $tableNumber }}
                    @else
                        Bawa Pulang
                    @endif
                </p>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 py-6 flex">
        @include('livewire.customer.partials.menu-sidebar', ['sidebarCategories' => $categories, 'activeSlug' => $category->slug])

        <main class="w-full md:w-[80%] min-w-0 md:pl-6">
            @php($icon = match($category->slug) {
                'ayam' => '🍗',
                'daging' => '🥩',
                'seafood' => '🦐',
                'sambal' => '🌶️',
                'cemal-cemil' => '🍟',
                'minuman' => '🥤',
                default => '🍽️',
            })
            <div class="flex items-center gap-3 mb-5">
                <span class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-3xl shrink-0">{{ $icon }}</span>
                <div>
                    <h2 class="text-2xl font-display font-bold text-dark leading-tight">{{ $category->name }}</h2>
                    <p class="text-sm text-warm-400">{{ $category->products->count() }} menu tersedia</p>
                </div>
            </div>

            @if($category->products->isNotEmpty())
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($category->products as $product)
                        @if($product->is_available)
                            <a href="{{ route('customer.product', $product->slug) }}" class="bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
                                <div class="relative aspect-[4/3] bg-warm-100 flex items-center justify-center overflow-hidden">
                                    @if ($product->image)
                                        <img src="{{ str_starts_with($product->image ?? '', 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-5xl">{{ $icon }}</span>
                                    @endif
                                    @if($product->is_featured)
                                        <span class="absolute top-2 left-2 text-[10px] font-bold uppercase tracking-wide bg-accent text-white px-2 py-0.5 rounded-full shadow">Favorit</span>
                                    @endif
                                </div>
                                <div class="p-3 flex flex-col flex-1">
                                    <h3 class="font-semibold text-dark text-sm leading-snug line-clamp-2 min-h-10">{{ $product->name }}</h3>
                                    <div class="mt-auto pt-2 flex items-center justify-between gap-2">
                                        <p class="text-sm font-bold text-primary">Rp {{ number_format($product->base_price, 0, ',', '.') }}</p>
                                        <span class="px-4 py-2 rounded-full bg-primary text-white text-xs font-bold hover:bg-primary-700 transition shrink-0">+ Tambah</span>
                                    </div>
                                </div>
                            </a>
                        @else
                            <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col opacity-70 relative">
                                <div class="aspect-[4/3] bg-warm-100 flex items-center justify-center overflow-hidden grayscale">
                                    <span class="text-5xl">{{ $icon }}</span>
                                </div>
                                <span class="absolute top-2 left-2 text-[10px] font-bold uppercase tracking-wide bg-warm-800 text-white px-2 py-0.5 rounded-full">Habis</span>
                                <div class="p-3 flex flex-col flex-1">
                                    <h3 class="font-semibold text-dark text-sm leading-snug line-clamp-2 min-h-10">{{ $product->name }}</h3>
                                    <div class="mt-auto pt-2 flex items-center justify-between gap-2">
                                        <p class="text-sm font-bold text-warm-400">Rp {{ number_format($product->base_price, 0, ',', '.') }}</p>
                                        <span class="px-4 py-2 rounded-full bg-warm-200 text-warm-400 text-xs font-bold shrink-0">Habis</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 text-warm-400">
                    <p class="text-5xl mb-4">{{ $icon }}</p>
                    <p class="font-medium">Belum ada menu di kategori ini</p>
                </div>
            @endif
        </main>
    </div>
</div>
