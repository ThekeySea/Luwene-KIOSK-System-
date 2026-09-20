<div wire:poll.15s>
    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        
        <div class="bg-white rounded-xl border border-gray-200 p-5 col-span-2 lg:col-span-1">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pendapatan</p>
                    <p class="text-xs text-gray-400 mt-0.5">Sebulan terakhir</p>
                </div>
                <?php echo $__env->make('livewire.staff.partials._trend-badge', ['trend' => $revenueTrend], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <p class="text-2xl font-display font-bold text-primary mt-3">Rp <?php echo e(number_format($revenueCurrent, 0, ',', '.')); ?></p>
        </div>

        
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pesanan</p>
                    <p class="text-xs text-gray-400 mt-0.5">Sepekan terakhir</p>
                </div>
                <?php echo $__env->make('livewire.staff.partials._trend-badge', ['trend' => $ordersTrend], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <p class="text-2xl font-display font-bold text-gray-900 mt-3"><?php echo e(number_format($ordersCurrent)); ?></p>
        </div>

        
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Menu Terjual</p>
                    <p class="text-xs text-gray-400 mt-0.5">Sebulan terakhir</p>
                </div>
                <?php echo $__env->make('livewire.staff.partials._trend-badge', ['trend' => $itemsTrend], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <p class="text-2xl font-display font-bold text-gray-900 mt-3"><?php echo e(number_format($itemsCurrent)); ?></p>
        </div>

        
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Produk</p>
            <p class="text-2xl font-display font-bold text-gray-900 mt-3"><?php echo e(number_format($totalProducts)); ?></p>
        </div>
    </div>

    
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-display font-bold text-gray-900">Pesanan Terbaru</h2>
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
            </span>
        </div>
        <div class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-semibold text-gray-900">#<?php echo e($order->order_number); ?></p>
                            <span class="inline-block text-[10px] px-2 py-0.5 rounded-full font-medium
                                <?php if($order->status === 'PENDING'): ?> bg-yellow-100 text-yellow-700
                                <?php elseif($order->status === 'CONFIRMED'): ?> bg-blue-100 text-blue-700
                                <?php elseif($order->status === 'PREPARING'): ?> bg-orange-100 text-orange-700
                                <?php elseif($order->status === 'READY'): ?> bg-purple-100 text-purple-700
                                <?php elseif($order->status === 'COMPLETED'): ?> bg-green-100 text-green-700
                                <?php else: ?> bg-red-100 text-red-700
                                <?php endif; ?>">
                                <?php echo e($order->status); ?>

                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">
                            <?php echo e($order->customer_name ?? $order->user->name ?? 'Guest'); ?>

                            &middot; <?php echo e($order->items->count()); ?> menu
                            &middot; <?php echo e($order->created_at->diffForHumans()); ?>

                        </p>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <p class="text-sm font-semibold text-primary">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></p>
                        <p class="text-[10px] text-gray-400"><?php echo e($order->created_at->format('d M, H:i')); ?></p>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="px-5 py-12 text-center text-gray-400 text-sm">Belum ada pesanan</div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/staff/admin-dashboard.blade.php ENDPATH**/ ?>