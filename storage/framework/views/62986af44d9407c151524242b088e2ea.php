<div class="min-h-dvh bg-dark-950/60 flex items-center justify-center p-4" x-data="{ show: false }" x-init="setTimeout(() => show = true, 80)">
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        class="w-full max-w-md bg-white rounded-3xl p-6 text-center shadow-2xl"
        role="dialog"
        aria-modal="true"
        aria-label="Pembayaran berhasil"
    >
        <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto">
            <svg class="w-10 h-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h2 class="text-2xl font-display font-bold text-dark mt-4">Pembayaran Berhasil!</h2>
        <p class="text-sm text-warm-500 mt-1">Terima kasih, <?php echo e($order->customer_name ?? 'pelanggan LUWENE'); ?>!</p>

        <div class="mt-5 bg-warm-50 rounded-2xl p-4 text-left space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-warm-500">Nomor Pesanan</span>
                <span class="font-bold text-dark">#<?php echo e($order->order_number); ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-warm-500">Total Bayar</span>
                <span class="font-bold text-primary">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-warm-500">Metode</span>
                <span class="font-medium text-dark"><?php echo e(($order->payment?->method ?? 'CASH') === 'QRIS' ? 'QRIS' : 'Tunai'); ?></span>
            </div>
        </div>

        <p class="text-xs text-warm-400 mt-3">Tunjukkan nomor pesanan ini ke kasir bila diperlukan.</p>
        <p class="text-xs text-warm-400 mt-1">Struk belanja otomatis terunduh. <a href="<?php echo e(route('customer.order-receipt', $order->id)); ?>" class="text-primary font-medium hover:underline">Unduh ulang</a></p>

        <div class="mt-5 space-y-2.5">
            <a href="<?php echo e(route('customer.menu')); ?>" class="block w-full py-3.5 bg-primary text-white font-semibold rounded-xl hover:bg-primary-700 transition">
                Kembali ke Menu
            </a>
            <a href="<?php echo e(route('home')); ?>" class="block w-full py-3.5 bg-white border-2 border-warm-200 text-dark font-semibold rounded-xl hover:border-primary hover:text-primary transition">
                Kembali ke Halaman Awal
            </a>
        </div>
    </div>
    <iframe src="<?php echo e(route('customer.order-receipt', $order->id)); ?>" class="hidden" title="Unduh struk otomatis" aria-hidden="true"></iframe>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/order-success.blade.php ENDPATH**/ ?>