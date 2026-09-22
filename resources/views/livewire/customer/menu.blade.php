<div class="min-h-dvh bg-warm-50 pb-8 md:pt-16">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-3">
            <a href="{{ route('home') }}" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition" aria-label="Kembali">
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
        @include('livewire.customer.partials.menu-sidebar', ['sidebarCategories' => $categories, 'activeSlug' => null])

        <main class="w-full md:w-[80%] min-w-0 md:pl-6">
            <div class="mb-5">
                <h2 class="text-2xl font-display font-bold text-dark leading-tight">Pilih Kategori</h2>
                <p class="text-sm text-warm-400 mt-1">Mau makan apa hari ini?</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($categories as $category)
                    @php($icon = match($category->slug) {
                        'ayam' => '🍗',
                        'daging' => '🥩',
                        'seafood' => '🦐',
                        'sambal' => '🌶️',
                        'cemal-cemil' => '🍟',
                        'minuman' => '🥤',
                        default => '🍽️',
                    })
                    <a href="{{ route('customer.menu.category', $category->slug) }}" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm hover:shadow-md transition flex flex-col items-center text-center gap-2 min-h-[12rem] justify-center">
                        <span class="text-5xl sm:text-6xl">{{ $icon }}</span>
                        <span class="font-display font-bold text-dark text-lg leading-tight">{{ $category->name }}</span>
                        <span class="text-xs text-warm-400">{{ $category->products_count }} menu</span>
                        <span class="mt-1 inline-flex items-center gap-1 text-xs font-bold text-primary">
                            Lihat
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </a>
                @endforeach
            </div>
        </main>
    </div>
</div>
