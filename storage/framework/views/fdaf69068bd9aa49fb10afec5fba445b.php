<div wire:poll.5s>
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-display font-bold text-gray-900">LUWENE <span class="text-primary">POS</span></h1>
                <p class="text-xs text-primary font-semibold bg-primary/10 inline-block px-2 py-0.5 rounded-full mt-0.5">Kasir</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500"><?php echo e(Auth::user()->name); ?></span>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-sm font-medium text-gray-500 bg-gray-100 hover:bg-red-50 hover:text-red-600 px-3 py-1.5 rounded-lg transition">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl p-5 border border-gray-200">
                <p class="text-sm text-gray-400">Pesanan Hari Ini</p>
                <p class="text-3xl font-display font-bold text-gray-900 mt-1"><?php echo e($todayOrders); ?></p>
            </div>
            <div class="bg-white rounded-xl p-5 border border-gray-200">
                <p class="text-sm text-gray-400">Pendapatan Hari Ini</p>
                <p class="text-3xl font-display font-bold text-primary mt-1">Rp <?php echo e(number_format($todayRevenue, 0, ',', '.')); ?></p>
            </div>
            <div class="bg-white rounded-xl p-5 border border-gray-200">
                <p class="text-sm text-gray-400">Menunggu Diproses</p>
                <p class="text-3xl font-display font-bold text-accent mt-1"><?php echo e($pendingOrders); ?></p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <a href="<?php echo e(route('cashier.pos')); ?>" class="block bg-primary rounded-xl p-6 text-center hover:bg-primary-700 transition">
                <svg class="w-12 h-12 text-white mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                <h2 class="text-xl font-display font-bold text-white">Buka POS</h2>
                <p class="text-sm text-white/70 mt-1">Mulai menerima pesanan</p>
            </a>
            <a href="<?php echo e(route('cashier.scan')); ?>" class="block bg-white border-2 border-gray-200 rounded-xl p-6 text-center hover:border-primary transition">
                <svg class="w-12 h-12 text-primary mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <h2 class="text-xl font-display font-bold text-gray-900">Scan Barcode</h2>
                <p class="text-sm text-gray-400 mt-1">Konfirmasi pesanan instan</p>
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-display font-bold text-gray-900">Status Meja</h2>
            </div>
            <div class="p-5 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="relative border rounded-xl p-4 text-center transition
                        <?php echo e($table->status === 'AVAILABLE' ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50'); ?>">
                        <p class="text-2xl font-display font-bold <?php echo e($table->status === 'AVAILABLE' ? 'text-green-700' : 'text-red-600'); ?>"><?php echo e($table->table_number); ?></p>
                        <p class="text-xs <?php echo e($table->status === 'AVAILABLE' ? 'text-green-500' : 'text-red-400'); ?> mt-0.5"><?php echo e($table->capacity); ?>pk</p>
                        <span class="inline-block mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full
                            <?php echo e($table->status === 'AVAILABLE' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'); ?>">
                            <?php echo e($table->status === 'AVAILABLE' ? 'Kosong' : 'Terpakai'); ?>

                        </span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($table->status === 'OCCUPIED'): ?>
                            <button
                                wire:click="releaseTableById('<?php echo e($table->id); ?>')"
                                wire:loading.attr="disabled"
                                wire:target="releaseTableById('<?php echo e($table->id); ?>')"
                                class="mt-2 w-full text-[11px] font-semibold text-red-600 bg-white border border-red-200 rounded-lg py-1.5 hover:bg-red-100 transition disabled:opacity-50">
                                <span wire:loading.remove wire:target="releaseTableById('<?php echo e($table->id); ?>')">Lepas</span>
                                <span wire:loading wire:target="releaseTableById('<?php echo e($table->id); ?>')">...</span>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </main>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/staff/cashier-dashboard.blade.php ENDPATH**/ ?>