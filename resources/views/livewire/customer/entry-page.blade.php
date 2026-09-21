<div class="min-h-dvh bg-warm-50 flex flex-col">
    <style>
        .order-card { transition: transform 0.15s, box-shadow 0.15s; }
        .order-card:active { transform: scale(0.97); }
        .scroll-x { overflow-x: auto; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
        .scroll-x::-webkit-scrollbar { display: none; }

        @media (min-width: 1024px) and (orientation: portrait) {
            html.kiosk .order-card {
                padding: 2rem;
                border-radius: 1.5rem;
                gap: 1rem;
            }
            html.kiosk .order-card .order-icon-box {
                width: 6rem;
                height: 6rem;
                border-radius: 1rem;
            }
            html.kiosk .order-card .order-icon-box svg {
                width: 3.5rem;
                height: 3.5rem;
            }
            html.kiosk .order-card .order-label {
                font-size: 1.25rem;
            }
        }
    </style>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SECTION 1: HEADER                                        --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <header class="bg-[#8A0000] text-white">
        <div class="max-w-3xl mx-auto px-5 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                    </svg>
                </div>
                <h1 class="text-xl font-display font-bold tracking-wide">LUWENE</h1>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold">Luwene, Ahli Pengenyang Perut</p>
                <p class="text-[11px] text-white/70">Selamat Datang di LUWENE</p>
            </div>
        </div>
    </header>

    <main class="flex-1">
        @if (session('error'))
            <div class="max-w-3xl mx-auto px-5 mt-3">
                <div class="p-3 bg-red-50 text-red-600 rounded-xl text-sm text-center">{{ session('error') }}</div>
            </div>
        @endif

        {{-- ═══════════════════════════════════════════════════════════ --}}
        {{-- SECTION 2: 3 OPSI PEMESANAN                             --}}
        {{-- ═══════════════════════════════════════════════════════════ --}}
        <section class="max-w-3xl mx-auto px-5 py-6 kiosk:py-10">
            <h2 class="text-base font-display font-bold text-dark mb-4">Pilih Cara Pesan</h2>
            <div class="grid grid-cols-3 gap-3">
                {{-- Delivery --}}
                <button wire:click="selectDelivery"
                    class="order-card rounded-2xl p-4 flex flex-col items-center justify-center gap-2 bg-[#8B4513] text-white shadow-md hover:shadow-lg">
                    <div class="order-icon-box w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                    </div>
                    <span class="order-label text-sm font-bold leading-tight">Delivery</span>
                </button>

                {{-- Dine In --}}
                <button wire:click="selectDineIn"
                    class="order-card rounded-2xl p-4 flex flex-col items-center justify-center gap-2 bg-[#E8751A] text-white shadow-md hover:shadow-lg">
                    <div class="order-icon-box w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <span class="order-label text-sm font-bold leading-tight">Makan di Sini</span>
                </button>

                {{-- Take Away --}}
                <button wire:click="selectTakeAway"
                    class="order-card rounded-2xl p-4 flex flex-col items-center justify-center gap-2 bg-[#C62828] text-white shadow-md hover:shadow-lg">
                    <div class="order-icon-box w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="order-label text-sm font-bold leading-tight">Bawa Pulang</span>
                </button>
            </div>

            {{-- Dine In: Pilih Meja (inline) --}}
            @if($orderMode === 'DINE_IN')
                <div class="mt-5 bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
                    <button wire:click="$set('orderMode', '')" class="mb-3 text-warm-400 hover:text-dark transition flex items-center gap-1 text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        Kembali
                    </button>
                    <h3 class="text-sm font-display font-bold text-dark mb-3">Pilih Meja</h3>
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                        @foreach ($tables as $table)
                            <button
                                wire:click="selectTable('{{ $table->id }}')"
                                @disabled($table->status !== 'AVAILABLE')
                                class="aspect-square rounded-xl border-2 p-2 flex flex-col items-center justify-center transition text-sm
                                    @if($table->status === 'AVAILABLE')
                                        border-warm-200 bg-white hover:border-[#E8751A] hover:bg-[#E8751A]/5 cursor-pointer
                                    @else
                                        border-warm-100 bg-warm-50 opacity-50 cursor-not-allowed
                                    @endif">
                                <span class="text-base font-bold {{ $table->status === 'AVAILABLE' ? 'text-dark' : 'text-warm-300' }}">{{ $table->table_number }}</span>
                                <span class="text-[10px] {{ $table->status === 'AVAILABLE' ? 'text-warm-400' : 'text-warm-300' }}">{{ $table->capacity }}pk</span>
                                <span class="mt-0.5 w-1.5 h-1.5 rounded-full {{ $table->status === 'AVAILABLE' ? 'bg-green-400' : 'bg-red-400' }}"></span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

        {{-- ═══════════════════════════════════════════════════════════ --}}
        {{-- SECTION 3: MENU TERLARIS                                 --}}
        {{-- ═══════════════════════════════════════════════════════════ --}}
        @if($popularProducts->isNotEmpty())
            <section class="py-6 bg-white">
                <div class="max-w-3xl mx-auto px-5">
                    <h2 class="text-base font-display font-bold text-dark mb-4">Favoritmu di Sini</h2>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($popularProducts->take(3) as $product)
                            @php
                                $catSlug = $product->category->slug ?? '';
                                $icon = match($catSlug) {
                                    'ayam' => '🍗',
                                    'daging' => '🥩',
                                    'seafood' => '🦐',
                                    default => '🍽️',
                                };
                            @endphp
                            <a href="{{ route('customer.product', $product->slug) }}" class="flex flex-col items-center gap-3 group">
                                <div class="w-full aspect-square rounded-2xl overflow-hidden shadow-sm group-hover:shadow-md transition">
                                    @if($product->image)
                                        <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-full bg-warm-100 flex items-center justify-center">
                                            <span class="text-5xl">{{ $icon }}</span>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-sm font-semibold text-dark text-center leading-tight">{{ $product->name }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- ═══════════════════════════════════════════════════════════ --}}
        {{-- SECTION 4: 5 LANGKAH ORDER                              --}}
        {{-- ═══════════════════════════════════════════════════════════ --}}
        <section class="py-6 bg-warm-50">
            <div class="max-w-3xl mx-auto px-5">
                <div class="inline-block bg-[#8A0000] text-white text-sm font-bold px-5 py-2 rounded-xl mb-5">
                    5 Langkah Order
                </div>
                <div class="space-y-4">
                    {{-- Step 1 --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#8A0000] rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-dark">Tentuin Cara Ordermu!</p>
                            <p class="text-xs text-warm-500 leading-relaxed">Mau Delivery? Dine in? Take Away? Sesuaikan dengan kebutuhanmu!</p>
                        </div>
                    </div>
                    {{-- Step 2 --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#8A0000] rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-dark">Pilih Menu</p>
                            <p class="text-xs text-warm-500 leading-relaxed">Pilih menu favoritmu sesuka hati. Ada banyak pilihan lezat!</p>
                        </div>
                    </div>
                    {{-- Step 3 --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#8A0000] rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-dark">Sesuaikan Pesanan</p>
                            <p class="text-xs text-warm-500 leading-relaxed">Pilih level sambal, nasi, dan extras lainnya sesuai seleramu.</p>
                        </div>
                    </div>
                    {{-- Step 4 --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#8A0000] rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-dark">Masukkan ke Nampan</p>
                            <p class="text-xs text-warm-500 leading-relaxed">Cek pesananmu di nampan, pastikan sudah lengkap.</p>
                        </div>
                    </div>
                    {{-- Step 5 --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#8A0000] rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-dark">Selesai & Bayar</p>
                            <p class="text-xs text-warm-500 leading-relaxed">Konfirmasi pesanan, bayar, dan nikmati makananmu!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SECTION 5: FOOTER                                        --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <footer class="bg-[#8A0000] text-white">
        <div class="max-w-3xl mx-auto px-5 py-6 text-center">
            <h2 class="text-xl font-display font-bold tracking-wide mb-1">LUWENE</h2>
            <p class="text-xs text-white/70 mb-3">Ayam Goreng Nikmat</p>
            <p class="text-[11px] text-white/60 leading-relaxed">Jl. Benowo No. 1, Surabaya</p>
            <div class="border-t border-white/20 mt-4 pt-3">
                <p class="text-[10px] text-white/50">&copy; {{ date('Y') }} LUWENE. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>
