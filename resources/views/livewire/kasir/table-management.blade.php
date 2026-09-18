<div class="min-h-dvh">
    <header class="sticky top-0 z-50 bg-dark-900/95 backdrop-blur-xl border-b border-dark-700">
        <div class="max-w-7xl mx-auto px-4 h-14 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="/kasir" class="text-accent font-bold text-sm">← Kembali</a>
                <span class="text-sm font-bold text-white">Manajemen Meja</span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
            @foreach($tables as $table)
                @php
                    $statusColor = match($table['status']) {
                        'AVAILABLE' => 'border-green-500/30 bg-green-500/5',
                        'OCCUPIED' => 'border-primary-500/30 bg-primary-500/5',
                        default => 'border-dark-600 bg-dark-800',
                    };
                    $statusLabel = match($table['status']) {
                        'AVAILABLE' => 'Kosong',
                        'OCCUPIED' => 'Terisi',
                        default => $table['status'],
                    };
                    $dotColor = match($table['status']) {
                        'AVAILABLE' => 'bg-green-500',
                        'OCCUPIED' => 'bg-primary-500',
                        default => 'bg-warm-500',
                    };
                @endphp
                <button wire:click="toggleStatus('{{ $table['id'] }}')"
                        class="rounded-xl border-2 p-4 text-center transition-all hover:scale-[1.02] {{ $statusColor }}">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $dotColor }}"></span>
                        <span class="font-bold text-lg text-white">{{ $table['table_number'] }}</span>
                    </div>
                    <p class="text-xs font-semibold text-warm-300">{{ $statusLabel }}</p>
                    <p class="text-[10px] text-warm-500 mt-1">{{ $table['capacity'] ?? 4 }} orang</p>
                </button>
            @endforeach
        </div>
    </main>
</div>
