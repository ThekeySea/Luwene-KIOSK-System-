<div class="min-h-dvh bg-warm-50">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('customer.packages') }}" class="text-warm-400 hover:text-dark transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-lg font-display font-bold text-dark">{{ $package->name }}</h1>
            <div class="w-6"></div>
        </div>
    </header>

    <div class="max-w-3xl mx-auto pb-32">
        <div class="aspect-[4/3] bg-warm-100">
            @if ($package->image)
                <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <span class="text-6xl">&#127873;</span>
                </div>
            @endif
        </div>

        <div class="px-4 py-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-display font-bold text-dark">{{ $package->name }}</h2>
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $package->type === 'MODULAR' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $package->type === 'MODULAR' ? 'Modular' : 'Tetap' }}
                        </span>
                    </div>
                </div>
                @if($package->type === 'FIXED')
                    <p class="text-xl font-bold text-primary">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                @endif
            </div>

            @if ($package->description)
                <p class="text-sm text-warm-600 mt-3">{{ $package->description }}</p>
            @endif
        </div>

        <form wire:submit.prevent="addToCart">
            <div class="px-4 space-y-6">
                {{-- Fixed Package --}}
                @if ($package->type === 'FIXED')
                    <div>
                        <h3 class="text-sm font-semibold text-dark mb-3">Isi Paket</h3>
                        <div class="space-y-2">
                            @foreach ($fixedItems as $item)
                                <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-warm-100">
                                    <span class="text-xl">🍽️</span>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-dark">{{ $item->product->name }}</p>
                                        <p class="text-xs text-warm-500">x{{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-sm text-warm-500">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Modular Package --}}
                @if ($package->type === 'MODULAR')
                    @php $sectionsCollect = $sections; @endphp
                    @foreach ($sectionsCollect as $sIndex => $section)
                        @if ($sIndex == $currentStep)
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="text-sm font-semibold text-dark">
                                        {{ $section->name }}
                                        @if ($section->choice_type === 'SINGLE')<span class="text-red-500">*</span>@endif
                                    </h3>
                                    <span class="text-xs text-warm-400">
                                        @if ($section->choice_type === 'SINGLE')
                                            Pilih 1
                                        @else
                                            Pilih maks {{ $section->max_pick }}
                                        @endif
                                    </span>
                                </div>
                                <p class="text-xs text-warm-400 mb-3">Langkah {{ $currentStep + 1 }} dari {{ $sectionsCollect->count() }}</p>

                                <div class="space-y-2">
                                    @foreach ($section->items as $item)
                                        @php
                                            $isSelected = $section->choice_type === 'SINGLE'
                                                ? ($selections[$sIndex] ?? '') === $item->id
                                                : in_array($item->id, $selections[$sIndex] ?? []);
                                        @endphp
                                        <label class="relative flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition
                                            {{ $isSelected ? 'border-primary bg-primary/10 shadow-sm' : 'border-warm-200 bg-white' }}">
                                            @if ($section->choice_type === 'SINGLE')
                                                <input type="radio" name="section_{{ $sIndex }}" wire:click="toggleSelection({{ $sIndex }}, '{{ $item->id }}')" class="w-5 h-5 accent-primary">
                                            @else
                                                <input type="checkbox" wire:click="toggleSelection({{ $sIndex }}, '{{ $item->id }}')"
                                                    {{ in_array($item->id, $selections[$sIndex] ?? []) ? 'checked' : '' }}
                                                    class="w-5 h-5 accent-primary rounded">
                                            @endif
                                            <div class="flex-1">
                                                <span class="text-sm font-medium text-dark">{{ $item->product->name }}</span>
                                            </div>
                                            <span class="text-sm text-accent">+Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                            @if($isSelected)
                                                <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center shrink-0" aria-hidden="true">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                                @error("selections.{$sIndex}") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif
                    @endforeach

                    {{-- Step navigation --}}
                    <div class="flex gap-2">
                        @if ($currentStep > 0)
                            <button type="button" wire:click="prevStep" class="flex-1 py-3 bg-warm-100 text-dark text-sm font-semibold rounded-xl hover:bg-warm-200 transition">
                                Kembali
                            </button>
                        @endif
                        @if ($currentStep < $sectionsCollect->count() - 1)
                            <button type="button" wire:click="nextStep" class="flex-1 py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition">
                                Selanjutnya
                            </button>
                        @endif
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
