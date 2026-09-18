@php
    $cart = session('cart', []);
    $cartCount = count($cart);
@endphp

<div>
    <x-navbar :cartCount="$cartCount" />

    <div class="pb-24">
        <div class="w-full aspect-[4/3] bg-gradient-to-br from-dark-800 to-dark-900 flex items-center justify-center relative">
            @if($product['image_url'])
                <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
            @else
                <span class="text-6xl">🍽️</span>
            @endif
            <a href="{{ route('customer.menu') }}" class="absolute top-4 left-4 w-10 h-10 bg-dark-800/80 backdrop-blur rounded-full flex items-center justify-center border border-dark-600">
                <svg class="w-5 h-5 text-warm-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        </div>

        <div class="px-4 pt-4">
            <span class="text-[10px] px-2 py-0.5 bg-dark-700 text-warm-400 rounded-full font-medium">{{ $product['category']['name'] ?? '' }}</span>
            <h1 class="text-xl font-bold text-white mt-2">{{ $product['name'] }}</h1>
            <p class="text-sm text-warm-400 mt-1">{{ $product['description'] }}</p>

            @if(!$product['is_available'])
                <div class="mt-3 p-3 bg-primary-500/10 border border-primary-500/20 rounded-xl text-sm text-primary-300 font-medium">
                    Menu ini sedang tidak tersedia
                </div>
            @endif
        </div>

        @if($error)
            <div class="mx-4 mt-4 p-3 bg-primary-500/10 border border-primary-500/20 rounded-xl text-sm text-primary-300">
                {{ $error }}
            </div>
        @endif

        <div class="px-4 mt-6 space-y-6">
            @if(count($product['variants']) > 0)
                <div>
                    <h3 class="text-sm font-bold text-white mb-3 uppercase tracking-wider">Tipe Pesanan</h3>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($product['variants'] as $variant)
                            <button wire:click="selectVariant('{{ $variant['id'] }}')"
                                    class="p-4 rounded-xl border-2 text-left transition-all
                                    {{ $selectedVariantId === $variant['id'] ? 'border-accent bg-accent/10' : 'border-dark-600 bg-dark-800 hover:border-dark-500' }}">
                                <p class="font-semibold text-sm text-white">{{ $variant['name'] }}</p>
                                <p class="text-accent font-bold text-lg mt-1">Rp {{ number_format($variant['price'], 0, ',', '.') }}</p>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($selectedVariantId && collect($product['variants'])->firstWhere('id', $selectedVariantId)?->name === 'Paket Nasi')
                @foreach($product['modifier_groups'] ?? $product['modifierGroups'] ?? [] as $group)
                    @if($group['name'] === 'Pilihan Nasi')
                        <div>
                            <h3 class="text-sm font-bold text-white mb-3 uppercase tracking-wider">Pilihan Nasi <span class="text-primary-400">*</span></h3>
                            <div class="space-y-2">
                                @foreach($group['modifiers'] as $nasi)
                                    <button wire:click="selectNasi('{{ $nasi['id'] }}')"
                                            class="w-full p-3 rounded-xl border-2 text-left flex items-center gap-3 transition-all
                                            {{ $selectedNasiId === $nasi['id'] ? 'border-accent bg-accent/10' : 'border-dark-600 bg-dark-800 hover:border-dark-500' }}">
                                        <div class="w-5 h-5 rounded-full border-2 {{ $selectedNasiId === $nasi['id'] ? 'border-accent bg-accent' : 'border-warm-600' }} flex items-center justify-center">
                                            @if($selectedNasiId === $nasi['id'])
                                                <div class="w-2 h-2 bg-white rounded-full"></div>
                                            @endif
                                        </div>
                                        <span class="text-sm text-warm-200">{{ $nasi['name'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif

            <div>
                <h3 class="text-sm font-bold text-white mb-3 uppercase tracking-wider">Sambal <span class="text-primary-400">*</span></h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($sambals as $sambal)
                        <button wire:click="selectSambal('{{ $sambal['id'] }}')"
                                class="p-3 rounded-xl border-2 text-left transition-all
                                {{ $selectedSambalId === $sambal['id'] ? 'border-accent bg-accent/10' : 'border-dark-600 bg-dark-800 hover:border-dark-500' }}">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full border-2 {{ $selectedSambalId === $sambal['id'] ? 'border-accent bg-accent' : 'border-warm-600' }} flex items-center justify-center">
                                    @if($selectedSambalId === $sambal['id'])
                                        <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                                    @endif
                                </div>
                                <span class="text-sm text-warm-200">{{ $sambal['name'] }}</span>
                            </div>
                            @if($sambal['price'] > 0)
                                <p class="text-xs text-warm-500 mt-1 ml-6">+Rp {{ number_format($sambal['price'], 0, ',', '.') }}</p>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-white mb-3 uppercase tracking-wider">Level Pedas <span class="text-primary-400">*</span></h3>
                <div class="grid grid-cols-4 gap-2">
                    @foreach($spiceLevels as $level)
                        @php
                            $colors = [
                                'bg-green-500/10 text-green-400 border-green-500/30',
                                'bg-yellow-500/10 text-yellow-400 border-yellow-500/30',
                                'bg-orange-500/10 text-orange-400 border-orange-500/30',
                                'bg-red-500/10 text-red-400 border-red-500/30',
                            ];
                            $activeColors = [
                                'bg-green-500 text-white border-green-500',
                                'bg-yellow-500 text-white border-yellow-500',
                                'bg-orange-500 text-white border-orange-500',
                                'bg-red-500 text-white border-red-500',
                            ];
                        @endphp
                        <button wire:click="selectLevel('{{ $level['id'] }}')"
                                class="p-3 rounded-xl border-2 text-center transition-all
                                {{ $selectedLevelId === $level['id'] ? $activeColors[$level['level_number']] : $colors[$level['level_number']] }}">
                            <p class="text-lg font-bold">{{ $level['level_number'] }}</p>
                            <p class="text-[10px] mt-0.5">{{ $level['name'] }}</p>
                        </button>
                    @endforeach
                </div>
            </div>

            @foreach($product['modifier_groups'] ?? $product['modifierGroups'] ?? [] as $group)
                @if($group['name'] === 'Extra')
                    <div>
                        <h3 class="text-sm font-bold text-white mb-3 uppercase tracking-wider">Extra (Opsional)</h3>
                        <div class="space-y-2">
                            @foreach($group['modifiers'] as $extra)
                                <button wire:click="toggleExtra('{{ $extra['id'] }}')"
                                        class="w-full p-3 rounded-xl border-2 text-left flex items-center justify-between transition-all
                                        {{ in_array($extra['id'], $selectedExtras) ? 'border-accent bg-accent/10' : 'border-dark-600 bg-dark-800 hover:border-dark-500' }}">
                                    <div class="flex items-center gap-3">
                                        <div class="w-5 h-5 rounded-lg border-2 {{ in_array($extra['id'], $selectedExtras) ? 'border-accent bg-accent' : 'border-warm-600' }} flex items-center justify-center">
                                            @if(in_array($extra['id'], $selectedExtras))
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="text-sm text-warm-200">{{ $extra['name'] }}</span>
                                    </div>
                                    <span class="text-xs text-warm-500">+Rp {{ number_format($extra['price'], 0, ',', '.') }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            <div>
                <h3 class="text-sm font-bold text-white mb-3 uppercase tracking-wider">Jumlah</h3>
                <div class="flex items-center gap-4">
                    <button wire:click="decrementQty"
                            class="w-10 h-10 rounded-xl border-2 border-dark-600 bg-dark-800 flex items-center justify-center text-lg font-bold text-warm-300 hover:border-dark-500 transition-colors">−</button>
                    <span class="text-xl font-bold w-8 text-center text-white">{{ $quantity }}</span>
                    <button wire:click="incrementQty"
                            class="w-10 h-10 rounded-xl border-2 border-dark-600 bg-dark-800 flex items-center justify-center text-lg font-bold text-warm-300 hover:border-dark-500 transition-colors">+</button>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-white mb-3 uppercase tracking-wider">Catatan (Opsional)</h3>
                <textarea wire:model="notes" placeholder="Contoh: tanpa bawang, ekstra pedas..."
                          class="w-full px-4 py-3 bg-dark-800 border border-dark-600 rounded-xl text-sm text-warm-100 placeholder-warm-500 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent/50 resize-none" rows="2"></textarea>
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-dark-800/95 backdrop-blur-xl border-t border-dark-700 p-4 z-50">
            <div class="max-w-lg mx-auto">
                <button wire:click="addToCart"
                        class="w-full bg-accent hover:bg-accent-500 text-white py-3.5 rounded-xl font-bold text-sm active:scale-[0.98] transition-all shadow-lg shadow-accent/20
                        {{ !$product['is_available'] ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ !$product['is_available'] ? 'disabled' : '' }}>
                    Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>
</div>
