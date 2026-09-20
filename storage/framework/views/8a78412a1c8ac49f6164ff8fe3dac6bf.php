<div class="min-h-dvh bg-warm-50">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="<?php echo e(route('customer.menu')); ?>" class="text-warm-400 hover:text-dark transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-lg font-display font-bold text-dark">Paket</h1>
            <div class="w-6"></div>
        </div>
    </header>

    <div class="max-w-3xl mx-auto px-4 py-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($packages->isEmpty()): ?>
            <div class="text-center py-16">
                <p class="text-warm-400 text-sm">Belum ada paket tersedia.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <a href="<?php echo e(route('customer.package', $pkg->code)); ?>" class="bg-white rounded-2xl shadow-sm border border-warm-100 overflow-hidden hover:shadow-md transition">
                        <div class="flex">
                            <div class="w-28 h-28 bg-warm-100 flex items-center justify-center shrink-0">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pkg->image): ?>
                                    <img src="<?php echo e(asset('storage/'.$pkg->image)); ?>" alt="<?php echo e($pkg->name); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <span class="text-4xl">&#127873;</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="flex-1 p-4 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-display font-bold text-dark"><?php echo e($pkg->name); ?></h3>
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium <?php echo e($pkg->type === 'MODULAR' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700'); ?>">
                                            <?php echo e($pkg->type === 'MODULAR' ? 'Modular' : 'Tetap'); ?>

                                        </span>
                                    </div>
                                    <p class="text-xs text-warm-500 mt-1"><?php echo e($pkg->description); ?></p>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pkg->type === 'FIXED'): ?>
                                        <p class="text-lg font-bold text-primary">Rp <?php echo e(number_format($pkg->price, 0, ',', '.')); ?></p>
                                    <?php else: ?>
                                        <p class="text-sm text-warm-500">Mulai dari harga pilihan</p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <span class="text-xs text-warm-400"><?php echo e($pkg->items_count); ?> item</span>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/packages.blade.php ENDPATH**/ ?>