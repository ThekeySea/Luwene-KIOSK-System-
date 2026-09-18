    <div class="min-h-dvh bg-warm-50">
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
                <a href="{{ route('customer.dashboard') }}" class="text-warm-400 hover:text-dark transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-lg font-display font-bold text-dark">Pesanan Saya</h1>
                <div class="w-6"></div>
            </div>
        </header>

        <div class="max-w-3xl mx-auto p-4">
            @forelse ($orders as $order)
                <div class="bg-white rounded-2xl p-4 shadow-sm mb-3">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-bold text-dark">#{{ $order->order_number }}</p>
                        <span class="inline-block text-xs px-2 py-0.5 rounded-full font-medium
                            @if($order->status === 'PENDING') bg-yellow-100 text-yellow-700
                            @elseif($order->status === 'CONFIRMED') bg-blue-100 text-blue-700
                            @elseif($order->status === 'PREPARING') bg-orange-100 text-orange-700
                            @elseif($order->status === 'READY') bg-green-100 text-green-700
                            @elseif($order->status === 'COMPLETED') bg-green-500/20 text-green-700
                            @else bg-red-100 text-red-700
                            @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                    <div class="space-y-1">
                        @foreach ($order->items as $item)
                            <p class="text-sm text-warm-600">{{ $item->quantity }}x {{ $item->product_name }}</p>
                        @endforeach
                    </div>
                    <div class="mt-2 pt-2 border-t border-warm-100 flex justify-between">
                        <span class="text-xs text-warm-400">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        <span class="text-sm font-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-warm-400">
                    <p>Belum ada pesanan</p>
                </div>
            @endforelse
        </div>
    </div>
