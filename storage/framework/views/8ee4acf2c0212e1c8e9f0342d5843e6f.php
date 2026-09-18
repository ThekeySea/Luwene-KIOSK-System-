    <div class="min-h-dvh bg-warm-50">
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
                <a href="<?php echo e(route('customer.menu')); ?>" class="text-warm-400 hover:text-dark transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-lg font-display font-bold text-dark">Keranjang</h1>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($items) > 0): ?>
                    <button wire:click="clearCart" class="text-sm text-red-400 hover:text-red-600 transition">Hapus</button>
                <?php else: ?>
                    <div class="w-6"></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </header>

        <div class="max-w-3xl mx-auto p-4 pb-48">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($items) > 0): ?>
                <div class="mb-4 p-3 bg-white rounded-xl border border-warm-200">
                    <div class="flex items-center gap-2 text-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orderMode === 'DINE_IN'): ?>
                            <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            <span class="font-medium text-dark">Dine In &middot; Meja <?php echo e($tableNumber); ?></span>
                        <?php else: ?>
                            <svg class="w-4 h-4 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span class="font-medium text-dark">Bawa Pulang</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="bg-white rounded-2xl p-4 shadow-sm">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-dark"><?php echo e($item['product_name']); ?></h3>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['variant']): ?>
                                        <p class="text-xs text-warm-400"><?php echo e($item['variant']['name']); ?> &middot; Rp <?php echo e(number_format($item['variant']['price'], 0, ',', '.')); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <button wire:click="removeItem('<?php echo e($item['id']); ?>')" class="text-warm-300 hover:text-red-500 transition ml-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($item['modifiers']) > 0): ?>
                                <div class="flex flex-wrap gap-1 mb-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $item['modifiers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <span class="text-xs bg-warm-100 text-warm-600 px-2 py-0.5 rounded-full"><?php echo e($mod['name']); ?></span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <button wire:click="updateQuantity('<?php echo e($item['id']); ?>', <?php echo e($item['quantity'] - 1); ?>)" class="w-10 h-10 bg-warm-100 rounded-lg flex items-center justify-center text-dark font-bold hover:bg-warm-200 transition">-</button>
                                    <span class="font-bold text-dark"><?php echo e($item['quantity']); ?></span>
                                    <button wire:click="updateQuantity('<?php echo e($item['id']); ?>', <?php echo e($item['quantity'] + 1); ?>)" class="w-10 h-10 bg-warm-100 rounded-lg flex items-center justify-center text-dark font-bold hover:bg-warm-200 transition">+</button>
                                </div>
                                <p class="font-bold text-primary">Rp <?php echo e(number_format($item['subtotal'], 0, ',', '.')); ?></p>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <svg class="w-16 h-16 mx-auto mb-4 text-warm-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>
                    <h2 class="text-lg font-display font-bold text-dark mb-2">Keranjang Kosong</h2>
                    <p class="text-sm text-warm-500 mb-4">Yuk pilih menu favorit kamu!</p>
                    <a href="<?php echo e(route('customer.menu')); ?>" class="inline-block px-6 py-2 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 transition">
                        Lihat Menu
                    </a>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($items) > 0): ?>
            <div class="fixed bottom-24 left-0 right-0 bg-white border-t border-warm-100 z-20">
                <div class="max-w-3xl mx-auto p-4">
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-warm-500">Subtotal</span>
                            <span class="text-dark font-medium">Rp <?php echo e(number_format($subtotal, 0, ',', '.')); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discount > 0 && $promo): ?>
                            <div class="flex justify-between text-sm">
                                <span class="text-green-600 font-medium">Promo <?php echo e($promo->code); ?></span>
                                <span class="text-green-600 font-medium">-Rp <?php echo e(number_format($discount, 0, ',', '.')); ?></span>
                            </div>
                        <?php elseif($promoCode): ?>
                            <div class="flex justify-between text-sm">
                                <span class="text-warm-400">Promo <?php echo e($promoCode); ?> (belum memenuhi syarat)</span>
                                <a href="<?php echo e(route('customer.promo')); ?>" class="text-primary font-medium">Cek</a>
                            </div>
                        <?php else: ?>
                            <div class="flex justify-between text-sm">
                                <a href="<?php echo e(route('customer.promo')); ?>" class="text-primary font-medium">Punya kode promo? Pakai di sini →</a>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-warm-500">PPN (11%)</span>
                            <span class="text-dark font-medium">Rp <?php echo e(number_format($tax, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-2 border-t border-warm-100">
                            <span class="text-dark">Total</span>
                            <span class="text-primary">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                    <a href="<?php echo e(route('customer.info')); ?>" class="block w-full py-4 text-lg bg-primary text-white text-center font-semibold rounded-xl hover:bg-primary/90 transition">
                        Lanjut
                    </a>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/cart.blade.php ENDPATH**/ ?>