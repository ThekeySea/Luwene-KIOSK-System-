<div class="min-h-[calc(100dvh-64px)]">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('cashier.dashboard') }}" class="text-gray-400 hover:text-gray-900 transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-lg font-display font-bold text-gray-900">Scan Barcode</h1>
            </div>
            <span class="text-sm text-gray-500">{{ Auth::user()->name }}</span>
        </div>
    </header>

    <main class="max-w-lg mx-auto p-4" x-data @scan-done.window="$refs.codeInput.focus()">
        <form wire:submit="process" class="bg-white rounded-xl border border-gray-200 p-5">
            <label for="scan-code" class="block text-sm font-medium text-gray-600 mb-2">Nomor Pesanan</label>
            <div class="flex gap-2">
                <input
                    type="text"
                    x-ref="codeInput"
                    wire:model="code"
                    id="scan-code"
                    autofocus
                    autocomplete="off"
                    class="flex-1 min-w-0 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 font-mono font-bold uppercase tracking-widest placeholder:normal-case placeholder:font-sans placeholder:font-normal placeholder:tracking-normal focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                    placeholder="Scan / ketik, mis. LW-00008"
                />
                <button
                    type="submit"
                    class="px-5 py-3 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary-700 transition shrink-0"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50"
                >
                    OK
                </button>
            </div>
            <p class="text-xs text-gray-400 mt-2">Arahkan scanner ke barcode struk — pesanan PENDING otomatis terkonfirmasi.</p>
        </form>

        @if($result)
            <div class="mt-4 rounded-xl border p-5 {{ $result['confirmed_now'] ? 'bg-green-50 border-green-200' : 'bg-white border-gray-200' }}">
                @if($result['confirmed_now'])
                    <p class="text-green-600 font-bold">&#10003; TERKONFIRMASI</p>
                @else
                    <p class="text-gray-600 font-bold">Status: {{ $result['status'] }}</p>
                @endif
                <p class="text-2xl font-display font-bold text-gray-900 mt-1">#{{ $result['order_number'] }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $result['customer_name'] }} &middot; {{ $result['item_count'] }} item</p>
                <p class="text-sm text-primary font-semibold mt-0.5">Rp {{ number_format($result['total'], 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $result['mode'] === 'DINE_IN' ? 'Dine In'.($result['table'] ? ' · Meja '.$result['table'] : '') : 'Bawa Pulang' }}</p>
                <div class="mt-4">
                    <a href="{{ route('cashier.pos') }}" class="block py-2.5 bg-gray-100 text-gray-700 text-sm text-center font-semibold rounded-xl hover:bg-gray-200 transition">Ke POS</a>
                </div>
            </div>
        @endif
    </main>
</div>
