    <div class="min-h-dvh bg-warm-50">
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
                <a href="<?php echo e(route('customer.info')); ?>" class="text-warm-400 hover:text-dark transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-lg font-display font-bold text-dark">Pembayaran</h1>
                <div class="w-6"></div>
            </div>
        </header>

        <div class="max-w-3xl mx-auto p-4 pb-48">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="mb-4 p-3 bg-red-50 text-red-600 rounded-xl text-sm"><?php echo e(session('error')); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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

            <div class="mb-4 p-3 bg-white rounded-xl border border-warm-200">
                <div class="flex items-center justify-between gap-2">
                    <div class="text-sm min-w-0">
                        <p class="font-medium text-dark truncate"><?php echo e($customerName); ?></p>
                        <p class="text-xs text-warm-400 truncate"><?php echo e($customerEmail); ?> &middot; <?php echo e($customerPhone); ?></p>
                    </div>
                    <a href="<?php echo e(route('customer.info')); ?>" class="text-xs font-medium text-primary hover:underline shrink-0">Ubah</a>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm mb-4">
                <h2 class="font-semibold text-dark mb-3">Ringkasan Pesanan</h2>
                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex justify-between">
                            <div class="flex-1">
                                <p class="text-sm text-dark"><?php echo e($item['quantity']); ?>x <?php echo e($item['product_name']); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['variant']): ?>
                                    <p class="text-xs text-warm-400"><?php echo e($item['variant']['name']); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($item['modifiers']) > 0): ?>
                                    <p class="text-xs text-warm-400">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $item['modifiers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php echo e($mod['name']); ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <p class="text-sm font-medium text-dark">Rp <?php echo e(number_format($item['subtotal'], 0, ',', '.')); ?></p>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm mb-4">
                <h2 class="font-semibold text-dark mb-3">Catatan (Opsional)</h2>
                <textarea
                    wire:model="notes"
                    class="w-full px-3 py-2 bg-warm-50 border border-warm-200 rounded-xl text-sm text-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition resize-none"
                    rows="2"
                    placeholder="Contoh: less pedas, tanpa bawang..."
                ></textarea>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm">
                <h2 class="font-semibold text-dark mb-3">Metode Pembayaran</h2>
                <div class="space-y-2">
                    <label class="relative flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition
                        <?php echo e($paymentMethod === 'CASH' ? 'border-primary bg-primary/10 shadow-sm' : 'bg-warm-50 border-transparent'); ?>">
                        <input type="radio" name="payment_method" wire:model.live="paymentMethod" value="CASH" class="w-5 h-5 accent-primary">
                        <div class="flex-1">
                            <span class="text-sm <?php echo e($paymentMethod === 'CASH' ? 'font-bold text-primary' : 'font-medium text-dark'); ?>">Tunai</span>
                            <p class="text-xs text-warm-400">Bayar langsung ke kasir</p>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paymentMethod === 'CASH'): ?>
                            <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center shrink-0" aria-hidden="true">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <span class="text-2xl">💵</span>
                    </label>
                    <label class="relative flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition
                        <?php echo e($paymentMethod === 'QRIS' ? 'border-primary bg-primary/10 shadow-sm' : 'bg-warm-50 border-transparent'); ?>">
                        <input type="radio" name="payment_method" wire:model.live="paymentMethod" value="QRIS" class="w-5 h-5 accent-primary">
                        <div class="flex-1">
                            <span class="text-sm <?php echo e($paymentMethod === 'QRIS' ? 'font-bold text-primary' : 'font-medium text-dark'); ?>">QRIS</span>
                            <p class="text-xs text-warm-400">Scan QR untuk bayar</p>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paymentMethod === 'QRIS'): ?>
                            <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center shrink-0" aria-hidden="true">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <span class="text-2xl">📱</span>
                    </label>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['paymentMethod'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-warm-100 z-20">
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
                <button
                    wire:click="submitOrder"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50"
                    class="block w-full py-4 text-lg bg-primary text-white text-center font-semibold rounded-xl hover:bg-primary/90 transition disabled:cursor-not-allowed">
                    <span wire:loading.remove>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paymentMethod === 'CASH'): ?>
                            Pesan & Bayar di Kasir
                        <?php else: ?>
                            Bayar dengan QRIS
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </span>
                    <span wire:loading>Memproses pesanan...</span>
                </button>
            </div>
        </div>

        
        <?php if (isset($component)) { $__componentOriginalcdabed30de7455caaf27f9a9c3d108e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcdabed30de7455caaf27f9a9c3d108e6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.qris-overlay','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('qris-overlay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcdabed30de7455caaf27f9a9c3d108e6)): ?>
<?php $attributes = $__attributesOriginalcdabed30de7455caaf27f9a9c3d108e6; ?>
<?php unset($__attributesOriginalcdabed30de7455caaf27f9a9c3d108e6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcdabed30de7455caaf27f9a9c3d108e6)): ?>
<?php $component = $__componentOriginalcdabed30de7455caaf27f9a9c3d108e6; ?>
<?php unset($__componentOriginalcdabed30de7455caaf27f9a9c3d108e6); ?>
<?php endif; ?>
    </div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/checkout.blade.php ENDPATH**/ ?>