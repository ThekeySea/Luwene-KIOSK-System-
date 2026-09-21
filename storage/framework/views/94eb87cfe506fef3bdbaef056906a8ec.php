<div class="min-h-dvh bg-warm-50 pb-32">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3 flex items-center gap-3">
            <a href="<?php echo e(route('delivery.home')); ?>" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-sm font-bold text-dark">Keranjang</h1>
        </div>
    </header>

    <main class="max-w-lg mx-auto px-4 py-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($items)): ?>
            <div class="text-center py-16">
                <p class="text-4xl mb-3">🛒</p>
                <p class="text-warm-500 text-sm">Keranjang masih kosong</p>
                <a href="<?php echo e(route('delivery.home')); ?>" class="inline-block mt-3 px-6 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-700 transition">Pesan Sekarang</a>
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-dark text-sm"><?php echo e($item['product_name']); ?></h3>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['variant']): ?>
                                    <p class="text-xs text-warm-500 mt-0.5"><?php echo e($item['variant']['name']); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['modifiers'])): ?>
                                    <p class="text-xs text-warm-400 mt-0.5">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $item['modifiers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php echo e($mod['name']); ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <button wire:click="removeItem(<?php echo \Illuminate\Support\Js::from($item['id'])->toHtml() ?>)" class="text-warm-400 hover:text-red-500 transition shrink-0 ml-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center gap-3">
                                <button wire:click="updateQuantity(<?php echo \Illuminate\Support\Js::from($item['id'])->toHtml() ?>, -1)" class="w-8 h-8 bg-warm-100 rounded-lg flex items-center justify-center text-dark font-bold hover:bg-warm-200 transition text-sm">-</button>
                                <span class="text-sm font-bold text-dark w-6 text-center"><?php echo e($item['quantity']); ?></span>
                                <button wire:click="updateQuantity(<?php echo \Illuminate\Support\Js::from($item['id'])->toHtml() ?>, 1)" class="w-8 h-8 bg-warm-100 rounded-lg flex items-center justify-center text-dark font-bold hover:bg-warm-200 transition text-sm">+</button>
                            </div>
                            <p class="text-sm font-bold text-primary">Rp <?php echo e(number_format($item['subtotal'], 0, ',', '.')); ?></p>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100 mt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-warm-500">Subtotal</span>
                    <span class="text-dark font-medium">Rp <?php echo e(number_format($subtotal, 0, ',', '.')); ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-warm-500">Ongkir</span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deliveryFee > 0): ?>
                        <span class="text-dark font-medium">Rp <?php echo e(number_format($deliveryFee, 0, ',', '.')); ?></span>
                    <?php else: ?>
                        <span class="text-green-600 font-medium">Gratis</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="flex justify-between text-lg font-bold pt-2 border-t border-warm-100">
                    <span class="text-dark">Total</span>
                    <span class="text-primary">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </main>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($items)): ?>
        <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-warm-100 z-20">
            <div class="max-w-lg mx-auto">
                <a href="<?php echo e(route('delivery.checkout')); ?>" class="flex items-center justify-between bg-primary text-white px-5 py-3.5 rounded-2xl shadow-lg hover:bg-primary-700 transition">
                    <div>
                        <p class="text-xs opacity-80"><?php echo e(count($items)); ?> item &middot; Ongkir Rp <?php echo e(number_format($deliveryFee, 0, ',', '.')); ?></p>
                        <p class="text-lg font-bold">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></p>
                    </div>
                    <span class="text-sm font-semibold">Checkout →</span>
                </a>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/delivery/cart.blade.php ENDPATH**/ ?>