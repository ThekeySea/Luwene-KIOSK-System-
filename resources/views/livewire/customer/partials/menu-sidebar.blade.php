<aside class="hidden md:block md:w-[20%] shrink-0 self-start sticky top-24">
    <div class="bg-white rounded-[2rem] shadow-md p-3 space-y-1 max-h-[calc(100dvh-8rem)] overflow-y-auto">
        <a href="{{ route('customer.menu') }}" class="flex items-center gap-3 px-4 py-3 rounded-full transition {{ ($activeSlug ?? null) === null ? 'bg-primary text-white font-bold shadow' : 'text-warm-600 hover:bg-warm-50' }}">
            <span class="text-2xl">🍽️</span>
            <span class="flex-1 text-sm">Semua Menu</span>
        </a>
        @foreach ($sidebarCategories as $sideCat)
            @php($sideIcon = match($sideCat->slug) {
                'ayam' => '🍗',
                'daging' => '🥩',
                'seafood' => '🦐',
                'sambal' => '🌶️',
                'cemal-cemil' => '🍟',
                'minuman' => '🥤',
                default => '🍽️',
            })
            <a href="{{ route('customer.menu.category', $sideCat->slug) }}" class="flex items-center gap-3 px-4 py-3 rounded-full transition {{ ($activeSlug ?? null) === $sideCat->slug ? 'bg-primary text-white font-bold shadow' : 'text-warm-600 hover:bg-warm-50' }}">
                <span class="text-2xl">{{ $sideIcon }}</span>
                <span class="flex-1 text-sm">{{ $sideCat->name }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full {{ ($activeSlug ?? null) === $sideCat->slug ? 'bg-white/20 text-white' : 'bg-warm-100 text-warm-500' }}">{{ $sideCat->products_count }}</span>
            </a>
        @endforeach
    </div>
</aside>
