<div class="min-h-dvh bg-warm-50">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('customer.menu') }}" class="text-warm-400 hover:text-dark transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-lg font-display font-bold text-dark">Detail Menu</h1>
            <div class="w-6"></div>
        </div>
    </header>

    <div class="max-w-3xl mx-auto pb-32">
        <div class="aspect-[4/3] bg-warm-100">
            @if ($product->image)
                <img src="{{ str_starts_with($product->image ?? '', 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-20 h-20 text-warm-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
            @endif
        </div>

        <div class="px-4 py-5">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-display font-bold text-dark">{{ $product->name }}</h2>
                    <p class="text-sm text-warm-500 mt-1">{{ $product->category->name }}</p>
                </div>
                <p class="text-xl font-bold text-primary">Rp {{ number_format($variantPrice, 0, ',', '.') }}</p>
            </div>

            @if ($product->description)
                <p class="text-sm text-warm-600 mt-3">{{ $product->description }}</p>
            @endif
        </div>

        <form wire:submit.prevent="addToCart">
            <div class="px-4 space-y-6">
                {{-- Variant --}}
                @if ($product->variants->count() > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-dark mb-3">Pilih Tipe</h3>
                        <div class="space-y-2">
                            @foreach ($product->variants as $variant)
                                <label class="relative flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition
                                    {{ $selectedVariant === $variant->id ? 'border-primary bg-primary/10 shadow-sm' : 'border-warm-200 bg-white' }}">
                                    <input type="radio" name="variant" wire:model.live="selectedVariant" value="{{ $variant->id }}" class="w-5 h-5 accent-primary">
                                    <div class="flex-1">
                                        <span class="text-sm {{ $selectedVariant === $variant->id ? 'font-bold text-primary' : 'font-medium text-dark' }}">{{ $variant->name }}</span>
                                    </div>
                                    <span class="text-sm font-semibold text-primary">Rp {{ number_format($variant->price, 0, ',', '.') }}</span>
                                    @if($selectedVariant === $variant->id)
                                        <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center shrink-0" aria-hidden="true">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                        @error('selectedVariant') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif

                {{-- Nasi --}}
                @if ($showNasi && $nasiGroup && $nasiGroup->modifiers->count() > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-dark mb-3">Pilih Nasi @if($nasiIsRequired)<span class="text-red-500">*</span>@else<span class="text-warm-400 font-normal">(Opsional)</span>@endif</h3>
                        <div class="space-y-2">
                            @foreach ($nasiGroup->modifiers as $nasi)
                                <label class="relative flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition
                                    {{ $selectedNasi === $nasi->id ? 'border-primary bg-primary/10 shadow-sm' : 'border-warm-200 bg-white' }}">
                                    <input type="radio" name="nasi" wire:model.live="selectedNasi" value="{{ $nasi->id }}" class="w-5 h-5 accent-primary">
                                    <div class="flex-1">
                                        <span class="text-sm {{ $selectedNasi === $nasi->id ? 'font-bold text-primary' : 'font-medium text-dark' }}">{{ $nasi->name }}</span>
                                    </div>
                                    @if($nasi->price > 0)
                                        <span class="text-sm text-accent">+Rp {{ number_format($nasi->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-xs text-warm-400">Gratis</span>
                                    @endif
                                    @if($selectedNasi === $nasi->id)
                                        <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center shrink-0" aria-hidden="true">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                        @error('selectedNasi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif

                {{-- Sambal --}}
                @if ($sambals->count() > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-dark mb-3">Pilih Sambal @if($sambalIsRequired)<span class="text-red-500">*</span>@else<span class="text-warm-400 font-normal">(Opsional)</span>@endif</h3>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach ($sambals as $sambal)
                                <label class="relative flex flex-col items-center p-3 rounded-xl border-2 cursor-pointer transition
                                    {{ $selectedSambal === $sambal->id ? 'border-primary bg-primary/10 shadow-sm' : 'border-warm-200 bg-white' }}">
                                    <input type="radio" name="sambal" wire:model.live="selectedSambal" value="{{ $sambal->id }}" class="sr-only">
                                    @if($selectedSambal === $sambal->id)
                                        <span class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full bg-primary text-white flex items-center justify-center" aria-hidden="true">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    @endif
                                    <span class="text-2xl mb-1">🌶️</span>
                                    <span class="text-xs font-medium text-dark text-center">{{ $sambal->name }}</span>
                                    @if($sambal->pivot->price > 0)
                                        <span class="text-xs text-accent">+Rp {{ number_format($sambal->pivot->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-[10px] text-green-600 font-medium">Gratis</span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                        @error('selectedSambal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif

                {{-- Spice Level --}}
                @if ($spiceLevels->count() > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-dark mb-3">Level Pedas <span class="text-red-500">*</span></h3>
                        <div class="grid grid-cols-{{ min($spiceLevels->count(), 4) }} gap-2">
                            @foreach ($spiceLevels as $level)
                                <label class="relative flex flex-col items-center p-3 rounded-xl border-2 cursor-pointer transition
                                    {{ $selectedSpiceLevel === $level->id ? 'border-primary bg-primary/10 shadow-sm' : 'border-warm-200 bg-white' }}">
                                    <input type="radio" name="spice_level" wire:model.live="selectedSpiceLevel" value="{{ $level->id }}" class="sr-only">
                                    @if($selectedSpiceLevel === $level->id)
                                        <span class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full bg-primary text-white flex items-center justify-center" aria-hidden="true">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    @endif
                                    <span class="text-lg font-bold
                                        @if($level->level === 0) text-green-500
                                        @elseif($level->level === 1) text-yellow-500
                                        @elseif($level->level === 2) text-orange-500
                                        @else text-red-500 @endif">
                                        @if($level->level === 0) 😋
                                        @elseif($level->level === 1) 😄
                                        @elseif($level->level === 2) 🥵
                                        @else 💀 @endif
                                    </span>
                                    <span class="text-xs font-medium text-dark">{{ $level->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('selectedSpiceLevel') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif

                {{-- Extras --}}
                @if ($extraGroup && $extraGroup->modifiers->count() > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-dark mb-3">Extra (Opsional)</h3>
                        <div class="space-y-2">
                            @foreach ($extraGroup->modifiers as $modifier)
                                <label class="flex items-center gap-3 p-3 bg-white rounded-xl border-2 cursor-pointer transition
                                    {{ in_array($modifier->id, $selectedExtras) ? 'border-accent bg-accent/10 shadow-sm' : 'border-warm-200 bg-white' }}">
                                    <input type="checkbox" wire:model.live="selectedExtras" value="{{ $modifier->id }}" class="w-5 h-5 accent-accent rounded">
                                    <div class="flex-1">
                                        <span class="text-sm font-medium text-dark">{{ $modifier->name }}</span>
                                    </div>
                                    <span class="text-sm text-accent">+Rp {{ number_format($modifier->price, 0, ',', '.') }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Quantity --}}
                <div>
                    <h3 class="text-sm font-semibold text-dark mb-3">Jumlah</h3>
                    <div class="flex items-center gap-4">
                        <button type="button" wire:click="$set('quantity', max(1, {{ $quantity }} - 1))" class="w-12 h-12 bg-warm-100 rounded-xl flex items-center justify-center text-dark font-bold hover:bg-warm-200 transition">-</button>
                        <span class="text-lg font-bold text-dark w-8 text-center">{{ $quantity }}</span>
                        <button type="button" wire:click="$set('quantity', min(20, {{ $quantity }} + 1))" class="w-12 h-12 bg-warm-100 rounded-xl flex items-center justify-center text-dark font-bold hover:bg-warm-200 transition">+</button>
                    </div>
                </div>
            </div>

            <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-warm-100 z-20">
                <div class="max-w-3xl mx-auto flex items-center justify-between">
                    <div>
                        <p class="text-xs text-warm-400">Total</p>
                        <p class="text-xl font-bold text-primary">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                    </div>
                    <button type="submit" class="px-8 py-4 text-lg bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 transition"
                        wire:loading.attr="disabled" wire:loading.class="opacity-50">
                        <span wire:loading.remove>Tambah ke Keranjang</span>
                        <span wire:loading>Menambahkan...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
