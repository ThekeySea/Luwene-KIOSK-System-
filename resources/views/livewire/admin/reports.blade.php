<div>
<div class="flex gap-2 mb-6">
    @foreach (['today' => 'Hari Ini', 'week' => '7 Hari', 'month' => '30 Hari'] as $value => $label)
        <button wire:click="setPreset('{{ $value }}')" class="px-4 py-2 rounded-lg text-xs font-semibold transition {{ $preset === $value ? 'bg-primary text-white' : 'bg-white border border-gray-200 text-gray-600 hover:text-gray-900' }}">{{ $label }}</button>
    @endforeach
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pendapatan</p>
        <p class="text-xl font-display font-bold text-primary mt-1">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Order</p>
        <p class="text-xl font-display font-bold text-gray-900 mt-1">{{ number_format($orderCount) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Terbayar</p>
        <p class="text-xl font-display font-bold text-gray-900 mt-1">{{ number_format($paidCount) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Rata-rata / Order</p>
        <p class="text-xl font-display font-bold text-gray-900 mt-1">Rp {{ number_format($average, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h2 class="font-display font-bold text-gray-900 mb-3">Produk Terlaris</h2>
        <div class="space-y-3">
            @forelse ($topProducts as $index => $product)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600 font-medium">{{ $index + 1 }}. {{ $product->product_name }}</span>
                        <span class="text-primary font-semibold">{{ $product->qty }}x</span>
                    </div>
                    <div class="h-2 rounded-full bg-gray-100 overflow-hidden">
                        <div class="h-full rounded-full bg-primary" style="width: {{ $topProducts->first()?->qty > 0 ? round($product->qty / $topProducts->first()->qty * 100) : 0 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400">Belum ada penjualan di periode ini.</p>
            @endforelse
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-display font-bold text-gray-900 mb-3">Order per Status</h2>
            <div class="flex flex-wrap gap-2">
                @forelse ($byStatus as $status => $total)
                    <span class="text-xs px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 font-medium">{{ $status }} &middot; {{ $total }}</span>
                @empty
                    <p class="text-sm text-gray-400">Tidak ada data.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-display font-bold text-gray-900 mb-3">Tipe Order</h2>
            <div class="flex flex-wrap gap-2">
                <span class="text-xs px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 font-medium">Dine In &middot; {{ $byMode['DINE_IN'] ?? 0 }}</span>
                <span class="text-xs px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 font-medium">Bawa Pulang &middot; {{ $byMode['TAKE_AWAY'] ?? 0 }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-display font-bold text-gray-900 mb-3">Metode Bayar (Lunas)</h2>
            <div class="space-y-2">
                @forelse ($byPayment as $row)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">{{ $row->method }}</span>
                        <span class="text-gray-900 font-medium">{{ $row->total }}x &middot; Rp {{ number_format($row->revenue, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">Tidak ada data.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>
