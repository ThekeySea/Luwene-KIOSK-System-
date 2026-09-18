    <div class="min-h-dvh bg-warm-50 flex flex-col">
        <header class="bg-white shadow-sm">
            <div class="max-w-3xl mx-auto px-4 py-5 text-center">
                <h1 class="text-4xl font-display font-bold text-primary tracking-tight">LUWENE</h1>
                <p class="text-warm-500 mt-1">Ayam Goreng Nikmat</p>
            </div>
        </header>

        <main class="flex-1 flex items-center justify-center p-4">
            <div class="w-full max-w-2xl">
                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-50 text-red-600 rounded-xl text-sm text-center">
                        {{ session('error') }}
                    </div>
                @endif

                @if (!$orderMode)
                    <div class="space-y-4">
                        <h2 class="text-2xl lg:text-3xl font-display font-bold text-dark text-center mb-6">Mau Pesan?</h2>

                        <button
                            wire:click="selectDineIn"
                            class="w-full bg-white border-2 border-primary rounded-3xl p-8 text-center lg:p-10 hover:bg-primary/5 transition group">
                            <svg class="w-16 h-16 text-primary mx-auto mb-3 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            <h3 class="text-2xl font-bold text-dark">Makan di Sini</h3>
                            <p class="text-sm text-warm-500 mt-1">Pilih meja dan nikmati di tempat</p>
                        </button>

                        <button
                            wire:click="selectTakeAway"
                            class="w-full bg-white border-2 border-warm-200 rounded-3xl p-8 text-center lg:p-10 hover:border-accent hover:bg-accent/5 transition group">
                            <svg class="w-16 h-16 text-accent mx-auto mb-3 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <h3 class="text-2xl font-bold text-dark">Bawa Pulang</h3>
                            <p class="text-sm text-warm-500 mt-1">Pesanan dibungkus untuk dibawa</p>
                        </button>
                    </div>
                @else
                    <div>
                        <button wire:click="$set('orderMode', '')" class="mb-4 text-warm-400 hover:text-dark transition flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </button>

                        <h2 class="text-xl font-display font-bold text-dark mb-4">Pilih Meja</h2>

                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-3">
                            @foreach ($tables as $table)
                                <button
                                    wire:click="selectTable('{{ $table->id }}')"
                                    @disabled($table->status !== 'AVAILABLE')
                                    class="aspect-square rounded-xl border-2 p-3 flex flex-col items-center justify-center transition
                                        @if($table->status === 'AVAILABLE')
                                            border-warm-200 bg-white hover:border-primary hover:bg-primary/5 cursor-pointer
                                        @else
                                            border-warm-100 bg-warm-50 opacity-50 cursor-not-allowed
                                        @endif">
                                    <span class="text-2xl font-bold {{ $table->status === 'AVAILABLE' ? 'text-dark' : 'text-warm-300' }}">
                                        {{ $table->table_number }}
                                    </span>
                                    <span class="text-xs {{ $table->status === 'AVAILABLE' ? 'text-warm-400' : 'text-warm-300' }}">
                                        {{ $table->capacity }}pk
                                    </span>
                                    <span class="mt-1 w-2 h-2 rounded-full {{ $table->status === 'AVAILABLE' ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </main>

        <footer class="p-4 text-center text-xs text-warm-300">
            &copy; {{ date('Y') }} LUWENE. All rights reserved.
        </footer>
    </div>
