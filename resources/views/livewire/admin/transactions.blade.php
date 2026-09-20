<div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    <input type="text" wire:model.live.debounce.300ms="search" class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-primary outline-none" placeholder="Cari nomor / nama..." />
    <select wire:model.live="statusFilter" class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none">
        <option value="">Semua status</option>
        @foreach (['PENDING', 'CONFIRMED', 'PREPARING', 'READY', 'COMPLETED', 'CANCELLED'] as $status)
            <option value="{{ $status }}">{{ $status }}</option>
        @endforeach
    </select>
    <select wire:model.live="paymentFilter" class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none">
        <option value="">Semua pembayaran</option>
        @foreach (['UNPAID', 'PAID', 'FAILED', 'REFUNDED'] as $payment)
            <option value="{{ $payment }}">{{ $payment }}</option>
        @endforeach
    </select>
    <input type="date" wire:model.live="dateFilter" class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="divide-y divide-gray-100">
        @forelse ($orders as $order)
            <div>
                <button wire:click="toggleExpand('{{ $order->id }}')" class="w-full px-5 py-4 flex items-center justify-between gap-3 text-left hover:bg-gray-50 transition">
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-900">#{{ $order->order_number }} <span class="font-normal text-gray-400">&middot; {{ $order->customer_name ?? 'Tanpa nama' }}</span></p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }} &middot; {{ $order->order_mode === 'DINE_IN' ? 'Dine In'.($order->table ? ' M'.$order->table->table_number : '') : 'Bawa Pulang' }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-sm font-semibold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $order->status }} &middot; {{ $order->payment_status }}</p>
                    </div>
                </button>
                @if($expandedId === $order->id)
                    <div class="px-5 pb-4 text-sm">
                        <div class="rounded-lg bg-gray-50 border border-gray-200 p-4 space-y-1.5">
                            @foreach ($order->items as $item)
                                <div class="flex justify-between gap-3">
                                    <span class="text-gray-600">{{ $item->quantity }}x {{ $item->product_name }}{{ $item->variant_name ? ' ('.$item->variant_name.')' : '' }}</span>
                                    <span class="text-gray-900 font-medium shrink-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                                @if($item->modifiers->count() > 0)
                                    <p class="text-xs text-gray-400 -mt-1">{{ $item->modifiers->pluck('modifier_name')->implode(', ') }}</p>
                                @endif
                            @endforeach
                            <div class="pt-2 mt-1 border-t border-gray-200 space-y-1">
                                <div class="flex justify-between text-gray-500"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                                @if((float) $order->discount_amount > 0)
                                    <div class="flex justify-between text-green-600"><span>Diskon</span><span>-Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span></div>
                                @endif
                                <div class="flex justify-between text-gray-500"><span>PPN</span><span>Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span></div>
                                <div class="flex justify-between text-gray-500"><span>Bayar via</span><span>{{ $order->payment?->method ?? '-' }}</span></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="px-5 py-12 text-center text-gray-400 text-sm">Tidak ada transaksi cocok filter.</div>
        @endforelse
    </div>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>
</div>
