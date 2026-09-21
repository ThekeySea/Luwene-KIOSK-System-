<div class="min-h-dvh bg-warm-50 pb-32">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3 flex items-center gap-3">
            <a href="<?php echo e(route('delivery.cart')); ?>" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-sm font-bold text-dark">Checkout</h1>
        </div>
    </header>

    <main class="max-w-lg mx-auto px-4 py-4 space-y-4">

        
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
            <h3 class="text-xs font-semibold text-warm-400 uppercase tracking-wide mb-3">Alamat Pengiriman</h3>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($addresses->isEmpty()): ?>
                <div class="text-center py-4">
                    <p class="text-sm text-warm-500 mb-2">Belum ada alamat tersimpan</p>
                    <a href="<?php echo e(route('delivery.profile')); ?>" class="text-sm font-semibold text-primary hover:underline">Tambah Alamat</a>
                </div>
            <?php else: ?>
                <div class="space-y-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <label wire:click="$set('selectedAddressId', '<?php echo e($address->id); ?>')"
                            class="flex items-start gap-3 p-3 rounded-xl border-2 cursor-pointer transition <?php echo e($selectedAddressId === $address->id ? 'border-primary bg-red-50' : 'border-warm-100 hover:border-warm-200'); ?>">
                            <input type="radio" name="address" value="<?php echo e($address->id); ?>"
                                wire:model="selectedAddressId"
                                class="mt-1 accent-primary">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-dark"><?php echo e($address->label); ?></span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($address->is_default): ?>
                                        <span class="text-[10px] px-1.5 py-0.5 bg-primary/10 text-primary rounded-full font-medium">Utama</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <p class="text-xs text-warm-500 mt-0.5 leading-relaxed"><?php echo e($address->address); ?></p>
                            </div>
                        </label>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <a href="<?php echo e(route('delivery.profile')); ?>" class="block text-center text-xs text-primary font-semibold mt-3 hover:underline">+ Tambah Alamat Baru</a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
            <h3 class="text-xs font-semibold text-warm-400 uppercase tracking-wide mb-2">Ringkasan Pesanan</h3>
            <div class="space-y-1.5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="flex justify-between items-start gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-dark truncate"><?php echo e($item['quantity']); ?>x <?php echo e($item['product_name']); ?></p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['variant'])): ?>
                                <p class="text-[11px] text-warm-400"><?php echo e($item['variant']['name']); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['modifiers'])): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $item['modifiers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mod['type'] !== 'SPICE_LEVEL'): ?>
                                        <p class="text-[11px] text-warm-400">+ <?php echo e($mod['name']); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <span class="text-sm font-medium text-dark shrink-0">Rp <?php echo e(number_format($item['subtotal'], 0, ',', '.')); ?></span>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
            <div class="border-t border-warm-100 mt-3 pt-3 space-y-1.5">
                <div class="flex justify-between text-sm">
                    <span class="text-warm-500">Subtotal</span>
                    <span>Rp <?php echo e(number_format($subtotal, 0, ',', '.')); ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-warm-500">Ongkir</span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deliveryFee > 0): ?>
                        <span>Rp <?php echo e(number_format($deliveryFee, 0, ',', '.')); ?></span>
                    <?php else: ?>
                        <span class="text-green-600 font-medium">Gratis</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="flex justify-between text-lg font-bold pt-2 border-t border-warm-100">
                    <span>Total</span>
                    <span class="text-primary">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
            <h3 class="text-xs font-semibold text-warm-400 uppercase tracking-wide mb-2">Catatan Pengiriman</h3>
            <textarea wire:model="deliveryNotes" rows="2" maxlength="200"
                class="w-full border border-warm-200 rounded-xl px-3 py-2.5 text-sm text-dark placeholder:text-warm-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary resize-none"
                placeholder="Contoh: Catat sambal extra, buzzer no 3, dll."></textarea>
            <p class="text-[11px] text-warm-300 mt-1 text-right"><?php echo e(strlen($deliveryNotes)); ?>/200</p>
        </div>

        
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-warm-100">
            <h3 class="text-xs font-semibold text-warm-400 uppercase tracking-wide mb-3">Metode Pembayaran</h3>
            <div class="space-y-2">
                <label wire:click="$set('paymentMethod', 'COD')"
                    class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition <?php echo e($paymentMethod === 'COD' ? 'border-primary bg-red-50' : 'border-warm-100 hover:border-warm-200'); ?>">
                    <input type="radio" name="payment" value="COD" wire:model="paymentMethod" class="accent-primary">
                    <div class="flex-1">
                        <span class="text-sm font-bold text-dark">Bayar di Tempat (COD)</span>
                        <p class="text-[11px] text-warm-400">Bayar saat pesanan tiba</p>
                    </div>
                    <span class="text-xl">💵</span>
                </label>
                <label wire:click="$set('paymentMethod', 'QRIS')"
                    class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition <?php echo e($paymentMethod === 'QRIS' ? 'border-primary bg-red-50' : 'border-warm-100 hover:border-warm-200'); ?>">
                    <input type="radio" name="payment" value="QRIS" wire:model="paymentMethod" class="accent-primary">
                    <div class="flex-1">
                        <span class="text-sm font-bold text-dark">QRIS</span>
                        <p class="text-[11px] text-warm-400">Bayar sekarang via QR</p>
                    </div>
                    <span class="text-xl">📱</span>
                </label>
            </div>
        </div>
    </main>

    
    <div class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-xl border-t border-warm-100 z-30 safe-bottom">
        <div class="max-w-lg mx-auto px-4 py-3">
            <button wire:click="submitOrder" wire:loading.attr="disabled"
                class="w-full py-3.5 rounded-xl font-bold text-white text-sm tracking-wide transition
                    <?php echo e($addresses->isEmpty() ? 'bg-warm-300 cursor-not-allowed' : 'bg-primary hover:bg-red-800 active:scale-[0.98]'); ?>"
                <?php echo e($addresses->isEmpty() ? 'disabled' : ''); ?>>
                <span wire:loading.remove wire:target="submitOrder">
                    Pesan Sekarang · Rp <?php echo e(number_format($total, 0, ',', '.')); ?>

                </span>
                <span wire:loading wire:target="submitOrder" class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                    Memproses...
                </span>
            </button>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/delivery/checkout.blade.php ENDPATH**/ ?>