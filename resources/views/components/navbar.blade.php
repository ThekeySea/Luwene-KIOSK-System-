@props(['cartCount' => 0, 'orderMode' => null, 'tableName' => null])

<header class="sticky top-0 z-50 bg-dark-800/95 backdrop-blur-xl border-b border-dark-700">
    <div class="max-w-lg mx-auto px-4 h-14 flex items-center justify-between">
        <a href="/" class="text-xl font-bold text-accent tracking-tight">LUWENE</a>
        <div class="flex items-center gap-3">
            @if($orderMode)
                <span class="text-xs px-2.5 py-1 rounded-full bg-accent/15 text-accent font-semibold">
                    {{ $orderMode === 'DINE_IN' ? 'Meja ' . ($tableName ?? '?') : 'Take Away' }}
                </span>
            @endif
            @if($cartCount > 0)
                <a href="/cart" class="relative">
                    <svg class="w-6 h-6 text-warm-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-accent text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                </a>
            @endif
        </div>
    </div>
</header>
