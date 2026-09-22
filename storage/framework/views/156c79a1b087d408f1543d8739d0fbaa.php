<div class="min-h-dvh bg-warm-50 pb-8 md:pt-16">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-3">
            <a href="<?php echo e(route('customer.menu')); ?>" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition" aria-label="Kembali">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-display font-bold text-primary leading-tight">LUWENE</h1>
                <p class="text-xs text-warm-400">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orderMode === 'DINE_IN'): ?>
                        Dine In &middot; Meja <?php echo e($tableNumber); ?>

                    <?php else: ?>
                        Bawa Pulang
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </p>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 py-6 flex">
        <?php echo $__env->make('livewire.customer.partials.menu-sidebar', ['sidebarCategories' => $categories, 'activeSlug' => $category->slug], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <main class="w-full md:w-[80%] min-w-0 md:pl-6">
            <?php ($icon = match($category->slug) {
                'ayam' => '🍗',
                'daging' => '🥩',
                'seafood' => '🦐',
                'sambal' => '🌶️',
                'cemal-cemil' => '🍟',
                'minuman' => '🥤',
                default => '🍽️',
            }); ?>
            <div class="flex items-center gap-3 mb-5">
                <span class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-3xl shrink-0"><?php echo e($icon); ?></span>
                <div>
                    <h2 class="text-2xl font-display font-bold text-dark leading-tight"><?php echo e($category->name); ?></h2>
                    <p class="text-sm text-warm-400"><?php echo e($category->products->count()); ?> menu tersedia</p>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->products->isNotEmpty()): ?>
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $category->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->is_available): ?>
                            <a href="<?php echo e(route('customer.product', $product->slug)); ?>" class="bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
                                <div class="relative aspect-[4/3] bg-warm-100 flex items-center justify-center overflow-hidden">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->image): ?>
                                        <img src="<?php echo e(str_starts_with($product->image ?? '', 'http') ? $product->image : asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <span class="text-5xl"><?php echo e($icon); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->is_featured): ?>
                                        <span class="absolute top-2 left-2 text-[10px] font-bold uppercase tracking-wide bg-accent text-white px-2 py-0.5 rounded-full shadow">Favorit</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="p-3 flex flex-col flex-1">
                                    <h3 class="font-semibold text-dark text-sm leading-snug line-clamp-2"><?php echo e($product->name); ?></h3>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->description): ?>
                                        <p class="text-[11px] text-warm-400 mt-0.5 line-clamp-1"><?php echo e(\Illuminate\Support\Str::words($product->description, 5, '...')); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="mt-auto pt-2">
                                        <p class="text-sm font-bold text-primary mb-2">Rp <?php echo e(number_format($product->base_price, 0, ',', '.')); ?></p>
                                        <span class="block w-full text-center py-2 rounded-full bg-primary text-white text-xs font-bold hover:bg-primary-700 transition">+ Tambah</span>
                                    </div>
                                </div>
                            </a>
                        <?php else: ?>
                            <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col opacity-70 relative">
                                <div class="aspect-[4/3] bg-warm-100 flex items-center justify-center overflow-hidden grayscale">
                                    <span class="text-5xl"><?php echo e($icon); ?></span>
                                </div>
                                <span class="absolute top-2 left-2 text-[10px] font-bold uppercase tracking-wide bg-warm-800 text-white px-2 py-0.5 rounded-full">Habis</span>
                                <div class="p-3 flex flex-col flex-1">
                                    <h3 class="font-semibold text-dark text-sm leading-snug line-clamp-2"><?php echo e($product->name); ?></h3>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->description): ?>
                                        <p class="text-[11px] text-warm-400 mt-0.5 line-clamp-1"><?php echo e(\Illuminate\Support\Str::words($product->description, 5, '...')); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="mt-auto pt-2">
                                        <p class="text-sm font-bold text-warm-400 mb-2">Rp <?php echo e(number_format($product->base_price, 0, ',', '.')); ?></p>
                                        <span class="block w-full text-center py-2 rounded-full bg-warm-200 text-warm-400 text-xs font-bold">Habis</span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-16 text-warm-400">
                    <p class="text-5xl mb-4"><?php echo e($icon); ?></p>
                    <p class="font-medium">Belum ada menu di kategori ini</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </main>
    </div>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/menu-category.blade.php ENDPATH**/ ?>