<div wire:poll.5s>
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-display font-bold text-gray-900">LUWENE <span class="text-primary">POS</span></h1>
                <p class="text-xs text-primary font-semibold bg-primary/10 inline-block px-2 py-0.5 rounded-full mt-0.5">Kasir</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-gray-500 bg-gray-100 hover:bg-red-50 hover:text-red-600 px-3 py-1.5 rounded-lg transition">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl p-5 border border-gray-200">
                <p class="text-sm text-gray-400">Pesanan Hari Ini</p>
                <p class="text-3xl font-display font-bold text-gray-900 mt-1">{{ $todayOrders }}</p>
            </div>
            <div class="bg-white rounded-xl p-5 border border-gray-200">
                <p class="text-sm text-gray-400">Pendapatan Hari Ini</p>
                <p class="text-3xl font-display font-bold text-primary mt-1">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl p-5 border border-gray-200">
                <p class="text-sm text-gray-400">Menunggu Diproses</p>
                <p class="text-3xl font-display font-bold text-accent mt-1">{{ $pendingOrders }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <a href="{{ route('cashier.pos') }}" class="block bg-primary rounded-xl p-6 text-center hover:bg-primary-700 transition">
                <svg class="w-12 h-12 text-white mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                <h2 class="text-xl font-display font-bold text-white">Buka POS</h2>
                <p class="text-sm text-white/70 mt-1">Mulai menerima pesanan</p>
            </a>
            <a href="{{ route('cashier.scan') }}" class="block bg-white border-2 border-gray-200 rounded-xl p-6 text-center hover:border-primary transition">
                <svg class="w-12 h-12 text-primary mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <h2 class="text-xl font-display font-bold text-gray-900">Scan Barcode</h2>
                <p class="text-sm text-gray-400 mt-1">Konfirmasi pesanan instan</p>
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="font-display font-bold text-gray-900">Status Meja</h2>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $tables->where('status', 'AVAILABLE')->count() }} kosong dari {{ $tables->count() }} meja</p>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span> Kosong</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-400"></span> Terpakai</span>
                </div>
            </div>
            <div class="p-5 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3">
                @forelse($tables as $table)
                    @php
                        $isOccupied = $table->status === 'OCCUPIED';
                    @endphp
                    <div class="group relative border-2 rounded-2xl p-4 text-center transition-all duration-200
                        {{ $isOccupied
                            ? 'border-red-200 bg-gradient-to-b from-red-50 to-white shadow-sm'
                            : 'border-emerald-200 bg-gradient-to-b from-emerald-50 to-white shadow-sm hover:shadow-md hover:border-emerald-300' }}">

                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center mb-2
                            {{ $isOccupied
                                ? 'bg-red-100 text-red-600'
                                : 'bg-emerald-100 text-emerald-600' }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5l16.5-4.5m0 0L21 11.25m-3.75-3.75v13.5m0 0L9 21m11.25-3.75L9 21" />
                            </svg>
                        </div>

                        <p class="text-lg font-display font-bold {{ $isOccupied ? 'text-red-700' : 'text-gray-900' }}">
                            {{ $table->table_number }}
                        </p>

                        <div class="flex items-center justify-center gap-1 mt-1">
                            <svg class="w-3 h-3 {{ $isOccupied ? 'text-red-400' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" />
                            </svg>
                            <span class="text-xs font-medium {{ $isOccupied ? 'text-red-500' : 'text-gray-500' }}">{{ $table->capacity }} orang</span>
                        </div>

                        @if($isOccupied)
                            <div class="mt-3 pt-3 border-t border-red-100">
                                <button
                                    wire:click="releaseTableById('{{ $table->id }}')"
                                    wire:loading.attr="disabled"
                                    wire:target="releaseTableById('{{ $table->id }}')"
                                    class="w-full text-xs font-semibold text-white bg-red-500 rounded-lg py-2 hover:bg-red-600 transition disabled:opacity-50 flex items-center justify-center gap-1">
                                    <span wire:loading.remove wire:target="releaseTableById('{{ $table->id }}')">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Lepas
                                    </span>
                                    <span wire:loading wire:target="releaseTableById('{{ $table->id }}')">...</span>
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 7.5l16.5-4.5m0 0L21 11.25m-3.75-3.75v13.5m0 0L9 21m11.25-3.75L9 21" />
                        </svg>
                        <p class="font-medium">Belum ada meja</p>
                        <p class="text-sm mt-1">Tambah meja melalui admin</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
