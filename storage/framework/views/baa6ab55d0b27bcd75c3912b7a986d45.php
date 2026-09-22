<div class="min-h-dvh bg-warm-50">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3 flex items-center gap-3">
            <a href="<?php echo e(route('delivery.profile')); ?>" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-sm font-bold text-dark">Riwayat Pesanan</h1>
        </div>
    </header>

    <main class="max-w-lg mx-auto px-4 py-4 space-y-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="text-sm font-bold text-dark">#<?php echo e($order->order_number); ?></p>
                        <p class="text-xs text-warm-400"><?php echo e($order->created_at->format('d M Y, H:i')); ?></p>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium
                        <?php if($order->status === 'PENDING'): ?> bg-yellow-100 text-yellow-700
                        <?php elseif($order->status === 'CONFIRMED'): ?> bg-blue-100 text-blue-700
                        <?php elseif($order->status === 'PREPARING'): ?> bg-orange-100 text-orange-700
                        <?php elseif($order->status === 'OUT_FOR_DELIVERY'): ?> bg-purple-100 text-purple-700
                        <?php elseif($order->status === 'DELIVERED' || $order->status === 'COMPLETED'): ?> bg-green-100 text-green-700
                        <?php else: ?> bg-red-100 text-red-700
                        <?php endif; ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'OUT_FOR_DELIVERY'): ?> Dikirim
                        <?php elseif($order->status === 'DELIVERED'): ?> Selesai
                        <?php else: ?> <?php echo e($order->status); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </span>
                </div>
                <div class="space-y-0.5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <p class="text-xs text-warm-600"><?php echo e($item->quantity); ?>x <?php echo e($item->product_name); ?></p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <div class="mt-2 pt-2 border-t border-warm-100 flex justify-between items-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->driver_name): ?>
                        <span class="text-xs text-warm-400">🛵 <?php echo e($order->driver_name); ?></span>
                    <?php elseif(!in_array($order->status, ['DELIVERED', 'CANCELLED', 'COMPLETED'])): ?>
                        <a href="<?php echo e(route('delivery.track', $order->id)); ?>" class="text-xs font-semibold text-primary hover:underline">Lacak Pesanan →</a>
                    <?php else: ?>
                        <span></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="flex items-center gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($order->status, ['DELIVERED', 'COMPLETED'])): ?>
                            <a href="<?php echo e(route('delivery.receipt', $order->id)); ?>" class="text-[11px] text-warm-400 hover:text-primary transition">📄 Struk</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <span class="text-sm font-bold text-primary">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                    </div>
                </div>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="text-center py-16">
                <p class="text-4xl mb-3">📋</p>
                <p class="text-warm-500 text-sm">Belum ada pesanan</p>
                <a href="<?php echo e(route('delivery.home')); ?>" class="inline-block mt-3 px-6 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-700 transition">Pesan Sekarang</a>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </main>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/delivery/orders.blade.php ENDPATH**/ ?>