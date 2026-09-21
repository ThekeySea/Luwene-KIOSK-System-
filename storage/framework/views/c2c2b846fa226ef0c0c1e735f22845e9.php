<div class="min-h-dvh bg-warm-50 pb-24">
    <form id="delivery-logout-form" method="POST" action="<?php echo e(route('delivery.logout')); ?>" class="hidden">
        <?php echo csrf_field(); ?>
    </form>
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <button type="button" onclick="document.getElementById('delivery-logout-form').submit()" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-warm-100 text-warm-500 hover:text-dark transition shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <span class="text-xl">🛵</span>
                    <div>
                        <p class="text-sm font-bold text-dark">LUWENE Benowo</p>
                        <p class="text-[10px] text-warm-400">Ongkir Rp <?php echo e(number_format($deliveryFee, 0, ',', '.')); ?> · <?php echo e($estMinutes); ?> min</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <a href="<?php echo e(route('delivery.cart')); ?>" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-warm-100 text-warm-500 transition relative">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                        </svg>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cartCount > 0): ?>
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center"><?php echo e($cartCount); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </a>
                    <a href="<?php echo e(route('delivery.profile')); ?>" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-warm-100 text-warm-500 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-warm-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" class="w-full bg-warm-100 rounded-xl pl-9 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-primary focus:bg-white transition" placeholder="Cari menu...">
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categories->isNotEmpty()): ?>
            <div class="max-w-lg mx-auto overflow-x-auto scrollbar-hide border-t border-warm-100">
                <div class="flex gap-0 px-4 py-2 min-w-max">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $catSlug = $cat->slug;
                            $icon = match($catSlug) {
                                'ayam' => '🍗',
                                'daging' => '🥩',
                                'seafood' => '🦐',
                                'sambal' => '🌶️',
                                'cemal-cemil' => '🍟',
                                'minuman' => '🥤',
                                default => '🍽️',
                            };
                        ?>
                        <span class="px-3 py-1 text-xs font-medium text-warm-600 whitespace-nowrap"><?php echo e($icon); ?> <?php echo e($cat->name); ?></span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </header>

    <main class="max-w-lg mx-auto px-4 py-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->isEmpty()): ?>
            <div class="text-center py-16">
                <p class="text-4xl mb-3">🍽️</p>
                <p class="text-warm-500 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                        Tidak ada menu untuk "<?php echo e($search); ?>"
                    <?php else: ?>
                        Menu belum tersedia
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 gap-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $catSlug = $product->category->slug ?? '';
                        $icon = match($catSlug) {
                            'ayam' => '🍗',
                            'daging' => '🥩',
                            'seafood' => '🦐',
                            'sambal' => '🌶️',
                            'cemal-cemil' => '🍟',
                            'minuman' => '🥤',
                            default => '🍽️',
                        };
                    ?>
                    <a href="<?php echo e(route('delivery.product', $product->slug)); ?>" class="bg-white rounded-2xl shadow-sm border border-warm-100 overflow-hidden hover:shadow-md transition flex flex-col">
                        <div class="aspect-[4/3] bg-warm-100 flex items-center justify-center relative">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->image): ?>
                                <img src="<?php echo e(str_starts_with($product->image, 'http') ? $product->image : asset('storage/'.$product->image)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-4xl"><?php echo e($icon); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->is_featured): ?>
                                <span class="absolute top-2 left-2 text-[9px] font-bold uppercase tracking-wide bg-accent text-white px-2 py-0.5 rounded-full shadow">Favorit</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="p-3 flex flex-col flex-1">
                            <h3 class="font-semibold text-dark text-xs leading-snug line-clamp-2 min-h-[2rem]"><?php echo e($product->name); ?></h3>
                            <div class="mt-auto pt-2">
                                <p class="text-sm font-bold text-primary">Rp <?php echo e(number_format($product->base_price, 0, ',', '.')); ?></p>
                            </div>
                        </div>
                    </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </main>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cartCount > 0): ?>
        <div class="fixed bottom-0 left-0 right-0 p-4 z-20">
            <div class="max-w-lg mx-auto">
                <a href="<?php echo e(route('delivery.cart')); ?>" class="flex items-center justify-between bg-primary text-white px-5 py-3.5 rounded-2xl shadow-lg hover:bg-primary-700 transition">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                            </svg>
                        </span>
                        <span class="text-sm font-semibold"><?php echo e($cartCount); ?> item</span>
                    </div>
                    <span class="text-sm font-bold">Lihat Keranjang →</span>
                </a>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/delivery/home.blade.php ENDPATH**/ ?>