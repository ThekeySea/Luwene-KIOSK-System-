<div class="min-h-dvh bg-warm-50 pb-32">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3 flex items-center gap-3">
            <a href="<?php echo e(route('delivery.orders')); ?>" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-line-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-sm font-bold text-dark">Lacak Pesanan</h1>
                <p class="text-[11px] text-warm-400">#<?php echo e($order->order_number); ?></p>
            </div>
        </div>
    </header>

    <main class="max-w-lg mx-auto px-4 py-4 space-y-4">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'CANCELLED'): ?>
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-center">
                <p class="text-2xl mb-1">❌</p>
                <p class="text-sm font-bold text-red-700">Pesanan Dibatalkan</p>
            </div>
        <?php elseif($order->status === 'DELIVERED'): ?>
            <div class="bg-green-50 border border-green-200 rounded-2xl p-4 text-center">
                <p class="text-2xl mb-1">🎉</p>
                <p class="text-sm font-bold text-green-700">Pesanan Sudah Tiba!</p>
                <p class="text-xs text-green-600 mt-1">Selamat menikmati</p>
            </div>
        <?php elseif($order->status === 'OUT_FOR_DELIVERY' && $estMinutes !== null && $estMinutes > 0): ?>
            <div class="bg-primary/5 border border-primary/20 rounded-2xl p-4 text-center">
                <p class="text-2xl mb-1">🛵</p>
                <p class="text-sm font-bold text-primary">Sedang Dalam Perjalanan</p>
                <p class="text-xs text-warm-500 mt-1">Estimasi tiba <?php echo e($estMinutes); ?> menit lagi</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
            <h3 class="text-xs font-semibold text-warm-400 uppercase tracking-wide mb-4">Status Pesanan</h3>
            <div class="space-y-0">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $statusSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php if($order->status === 'CANCELLED' && $step['key'] !== 'PENDING'): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php continue; ?><?php endif; ?>
                    <div class="flex items-start gap-3 relative">
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $loop->last): ?>
                            <div class="absolute left-[15px] top-[28px] w-0.5 h-full
                                <?php echo e($step['state'] === 'completed' ? 'bg-primary' : 'bg-warm-100'); ?>"></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 z-10 text-sm
                            <?php echo e($step['state'] === 'completed' ? 'bg-primary text-white' :
                               ($step['state'] === 'current' ? 'bg-primary/10 text-primary ring-2 ring-primary/30 animate-pulse' :
                               'bg-warm-100 text-warm-300')); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step['state'] === 'completed'): ?>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            <?php else: ?>
                                <?php echo e($step['icon']); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div class="pb-6 pt-1">
                            <p class="text-sm font-medium
                                <?php echo e($step['state'] === 'completed' ? 'text-dark' :
                                   ($step['state'] === 'current' ? 'text-primary font-bold' :
                                   'text-warm-300')); ?>">
                                <?php echo e($step['label']); ?>

                            </p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step['state'] === 'current' && $order->status !== 'OUT_FOR_DELIVERY'): ?>
                                <p class="text-[11px] text-warm-400 mt-0.5">Sedang diproses...</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'CANCELLED'): ?>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 z-10 text-sm bg-red-100 text-red-500">
                            ✕
                        </div>
                        <div class="pb-2 pt-1">
                            <p class="text-sm font-medium text-red-600">Dibatalkan</p>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->driver_name): ?>
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
                <h3 class="text-xs font-semibold text-warm-400 uppercase tracking-wide mb-3">Driver</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                        <span class="text-lg">🛵</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-dark"><?php echo e($order->driver_name); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->driver_phone): ?>
                            <p class="text-xs text-warm-400"><?php echo e($order->driver_phone); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
            <h3 class="text-xs font-semibold text-warm-400 uppercase tracking-wide mb-3">Detail Pesanan</h3>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->branch): ?>
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs text-warm-400">Dari</span>
                    <span class="text-xs font-semibold text-dark"><?php echo e($order->branch->name); ?></span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="flex items-start gap-2 mb-3">
                <span class="text-xs text-warm-400 shrink-0 mt-0.5">📍</span>
                <p class="text-xs text-dark"><?php echo e($order->delivery_address); ?></p>
            </div>

            
            <div class="border-t border-warm-100 pt-3 space-y-1.5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="flex justify-between items-start gap-3">
                        <p class="text-sm text-dark"><?php echo e($item->quantity); ?>x <?php echo e($item->product_name); ?></p>
                        <span class="text-sm font-medium text-dark shrink-0">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></span>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            
            <div class="border-t border-warm-100 mt-3 pt-3 space-y-1.5">
                <div class="flex justify-between text-sm">
                    <span class="text-warm-500">Subtotal</span>
                    <span>Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-warm-500">Ongkir</span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->delivery_fee > 0): ?>
                        <span>Rp <?php echo e(number_format($order->delivery_fee, 0, ',', '.')); ?></span>
                    <?php else: ?>
                        <span class="text-green-600 font-medium">Gratis</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="flex justify-between text-lg font-bold pt-2 border-t border-warm-100">
                    <span>Total</span>
                    <span class="text-primary">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                </div>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->delivery_notes): ?>
                <div class="mt-3 pt-3 border-t border-warm-100">
                    <p class="text-xs text-warm-400">Catatan:</p>
                    <p class="text-sm text-dark mt-0.5"><?php echo e($order->delivery_notes); ?></p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100 text-center">
            <p class="text-xs text-warm-400">Dipesan pada</p>
            <p class="text-sm font-medium text-dark mt-0.5"><?php echo e($order->created_at->format('d M Y, H:i')); ?></p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->delivery_estimated_at): ?>
                <p class="text-xs text-warm-400 mt-2">Estimasi tiba</p>
                <p class="text-sm font-medium text-primary mt-0.5"><?php echo e($order->delivery_estimated_at->format('H:i')); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <a href="<?php echo e(route('delivery.receipt', $order->id)); ?>" class="inline-block mt-3 text-xs font-semibold text-primary hover:underline">Unduh Struk PDF ↓</a>
        </div>
    </main>

    
    <div class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-xl border-t border-warm-100 z-30 safe-bottom">
        <div class="max-w-lg mx-auto px-4 py-3">
            <a href="<?php echo e(route('delivery.home')); ?>"
                class="block w-full py-3.5 rounded-xl font-bold text-white text-sm tracking-wide text-center bg-primary hover:bg-red-800 active:scale-[0.98] transition">
                Pesan Lagi
            </a>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/delivery/track-order.blade.php ENDPATH**/ ?>