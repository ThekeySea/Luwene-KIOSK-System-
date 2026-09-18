<div class="min-h-dvh">
    <header class="sticky top-0 z-50 bg-dark-900/95 backdrop-blur-xl border-b border-dark-700">
        <div class="max-w-7xl mx-auto px-4 h-14 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="/kasir" class="text-accent font-bold text-sm">← Kembali</a>
                <span class="text-sm font-bold text-white">Ketersediaan Menu</span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4">
        <div class="mb-4 flex gap-2 overflow-x-auto pb-2">
            <button wire:click="$set('selectedCategory', '')"
                    class="shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold border transition-all
                    {{ $selectedCategory === '' ? 'bg-accent text-white border-accent' : 'bg-dark-800 text-warm-400 border-dark-600 hover:border-dark-500' }}">
                Semua
            </button>
            @foreach($categories as $cat)
                <button wire:click="$set('selectedCategory', '{{ $cat['id'] }}')"
                        class="shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold border transition-all
                        {{ $selectedCategory === $cat['id'] ? 'bg-accent text-white border-accent' : 'bg-dark-800 text-warm-400 border-dark-600 hover:border-dark-500' }}">
                    {{ $cat['name'] }}
                </button>
            @endforeach
        </div>

        <div class="grid gap-2">
            @foreach($products as $product)
                <div class="bg-dark-800 rounded-xl border border-dark-700 p-3 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-sm text-white">{{ $product['name'] }}</p>
                        <p class="text-xs text-warm-500">{{ $product['category']['name'] ?? '' }}</p>
                    </div>
                    <button wire:click="toggleAvailability('{{ $product['id'] }}')"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors
                            {{ $product['is_available'] ? 'bg-green-500/15 text-green-400 hover:bg-green-500/25' : 'bg-primary-500/15 text-primary-400 hover:bg-primary-500/25' }}">
                        {{ $product['is_available'] ? 'Tersedia' : 'Habis' }}
                    </button>
                </div>
            @endforeach
        </div>
    </main>
</div>
