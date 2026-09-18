<aside class="hidden md:block md:w-[20%] shrink-0 self-start sticky top-24">
    <div class="bg-white rounded-[2rem] shadow-md p-3 space-y-1 max-h-[calc(100dvh-8rem)] overflow-y-auto">
        <a href="<?php echo e(route('customer.menu')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-full transition <?php echo e(($activeSlug ?? null) === null ? 'bg-primary text-white font-bold shadow' : 'text-warm-600 hover:bg-warm-50'); ?>">
            <span class="text-2xl">🍽️</span>
            <span class="flex-1 text-sm">Semua Menu</span>
        </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sidebarCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sideCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php ($sideIcon = match($sideCat->slug) {
                'ayam' => '🍗',
                'daging' => '🥩',
                'seafood' => '🦐',
                'sambal' => '🌶️',
                'cemal-cemil' => '🍟',
                'minuman' => '🥤',
                default => '🍽️',
            }); ?>
            <a href="<?php echo e(route('customer.menu.category', $sideCat->slug)); ?>" class="flex items-center gap-3 px-4 py-3 rounded-full transition <?php echo e(($activeSlug ?? null) === $sideCat->slug ? 'bg-primary text-white font-bold shadow' : 'text-warm-600 hover:bg-warm-50'); ?>">
                <span class="text-2xl"><?php echo e($sideIcon); ?></span>
                <span class="flex-1 text-sm"><?php echo e($sideCat->name); ?></span>
                <span class="text-xs px-2 py-0.5 rounded-full <?php echo e(($activeSlug ?? null) === $sideCat->slug ? 'bg-white/20 text-white' : 'bg-warm-100 text-warm-500'); ?>"><?php echo e($sideCat->products_count); ?></span>
            </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
</aside>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/partials/menu-sidebar.blade.php ENDPATH**/ ?>