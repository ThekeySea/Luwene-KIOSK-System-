<div class="min-h-dvh bg-warm-50">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('customer.menu') }}" class="text-warm-400 hover:text-dark transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-lg font-display font-bold text-dark">Paket</h1>
            <div class="w-6"></div>
        </div>
    </header>

    <div class="max-w-3xl mx-auto px-4 py-6">
        @if ($packages->isEmpty())
            <div class="text-center py-16">
                <p class="text-warm-400 text-sm">Belum ada paket tersedia.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4">
                @foreach ($packages as $pkg)
                    <a href="{{ route('customer.package', $pkg->code) }}" class="bg-white rounded-2xl shadow-sm border border-warm-100 overflow-hidden hover:shadow-md transition">
                        <div class="flex">
                            <div class="w-28 h-28 bg-warm-100 flex items-center justify-center shrink-0">
                                @if($pkg->image)
                                    <img src="{{ asset('storage/'.$pkg->image) }}" alt="{{ $pkg->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl">&#127873;</span>
                                @endif
                            </div>
                            <div class="flex-1 p-4 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-display font-bold text-dark">{{ $pkg->name }}</h3>
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $pkg->type === 'MODULAR' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $pkg->type === 'MODULAR' ? 'Modular' : 'Tetap' }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-warm-500 mt-1">{{ $pkg->description }}</p>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    @if($pkg->type === 'FIXED')
                                        <p class="text-lg font-bold text-primary">Rp {{ number_format($pkg->price, 0, ',', '.') }}</p>
                                    @else
                                        <p class="text-sm text-warm-500">Mulai dari harga pilihan</p>
                                    @endif
                                    <span class="text-xs text-warm-400">{{ $pkg->items_count }} item</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
