<div class="min-h-dvh bg-warm-50">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="text-xl">📍</span>
                    <div>
                        <p class="text-[10px] text-warm-400 uppercase tracking-wide">Alamat pengiriman</p>
                        <p class="text-sm font-semibold text-dark truncate max-w-[200px]">Surabaya</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ route('delivery.orders') }}" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-warm-100 text-warm-500 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
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
                <input type="text" wire:model.live="search" class="w-full bg-warm-100 rounded-xl pl-9 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-primary focus:bg-white transition" placeholder="Cari cabang...">
            </div>
        </div>
    </header>

    <main class="max-w-lg mx-auto px-4 py-4 space-y-3">
        @forelse ($branches as $branch)
            <a href="{{ route('delivery.branch', $branch['id']) }}" class="block bg-white rounded-2xl p-4 shadow-sm border border-warm-100 hover:shadow-md transition">
                <div class="flex gap-3">
                    <div class="w-20 h-20 bg-warm-100 rounded-xl flex items-center justify-center shrink-0">
                        <span class="text-3xl">🏪</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-dark text-sm">{{ $branch['name'] }}</h3>
                        <p class="text-xs text-warm-500 mt-0.5 truncate">{{ $branch['address'] }}</p>
                        <div class="flex items-center gap-3 mt-2">
                            @if($branch['distance_label'])
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-warm-600">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $branch['distance_label'] }}
                                </span>
                            @endif
                            @if($branch['estimated_delivery_minutes'])
                                <span class="inline-flex items-center gap-1 text-xs text-warm-500">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $branch['estimated_delivery_minutes'] }} min
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col items-end justify-between shrink-0">
                        @if($branch['delivery_fee'] !== null)
                            <span class="text-xs font-semibold text-primary">Rp {{ number_format($branch['delivery_fee'], 0, ',', '.') }}</span>
                        @else
                            <span class="text-xs text-green-600 font-semibold">Gratis</span>
                        @endif
                        <svg class="w-5 h-5 text-warm-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center py-16">
                <p class="text-4xl mb-3">🔍</p>
                <p class="text-warm-500 text-sm">
                    @if($search)
                        Tidak ada cabang untuk "{{ $search }}"
                    @else
                        Belum ada cabang tersedia
                    @endif
                </p>
            </div>
        @endforelse
    </main>
</div>
