<?php
    $isPackagesPage = request()->routeIs('customer.packages', 'customer.package');
?>
<aside class="hidden md:block md:w-[20%] shrink-0 self-start sticky top-24">
    <div class="relative">
        <div class="bg-white rounded-[2rem] shadow-md p-3 space-y-1 max-h-[calc(100dvh-8rem)] overflow-y-auto sidebar-scroll" id="menu-sidebar">
            <a href="<?php echo e(route('customer.menu')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-full transition <?php echo e(($activeSlug ?? null) === null && !$isPackagesPage ? 'bg-primary text-white font-bold shadow' : 'text-warm-600 hover:bg-warm-50'); ?>">
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

            <div class="!my-2 border-t border-warm-100 mx-2"></div>

            <a href="<?php echo e(route('customer.packages')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-full transition <?php echo e($isPackagesPage ? 'bg-primary text-white font-bold shadow' : 'text-warm-600 hover:bg-warm-50'); ?>">
                <span class="text-2xl">📦</span>
                <span class="flex-1 text-sm">Paket</span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($sidebarPackageCount) && $sidebarPackageCount > 0): ?>
                    <span class="text-xs px-2 py-0.5 rounded-full <?php echo e($isPackagesPage ? 'bg-white/20 text-white' : 'bg-warm-100 text-warm-500'); ?>"><?php echo e($sidebarPackageCount); ?></span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
        </div>

        <div class="pointer-events-none absolute bottom-14 left-0 right-0 h-8 rounded-b-[2rem] bg-gradient-to-t from-white to-transparent opacity-0 transition-opacity duration-200" id="sidebar-fade"></div>
        <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 opacity-0 transition-opacity duration-200" id="sidebar-indicator">
            <svg class="w-4 h-4 text-warm-400 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('menu-sidebar');
            const fade = document.getElementById('sidebar-fade');
            const indicator = document.getElementById('sidebar-indicator');
            if (!sidebar || !fade || !indicator) return;

            function check() {
                const canScroll = sidebar.scrollHeight > sidebar.clientHeight;
                const atBottom = sidebar.scrollTop + sidebar.clientHeight >= sidebar.scrollHeight - 4;
                fade.style.opacity = canScroll && !atBottom ? '1' : '0';
                indicator.style.opacity = canScroll && !atBottom ? '1' : '0';
            }

            sidebar.addEventListener('scroll', check);
            window.addEventListener('resize', check);
            check();
        });
    </script>
</aside>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/partials/menu-sidebar.blade.php ENDPATH**/ ?>