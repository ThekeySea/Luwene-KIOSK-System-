    <div class="h-dvh flex flex-col overflow-hidden bg-warm-50">
        <style>
            .entry-card {
                width: min(28vw, 30vh, 280px);
                aspect-ratio: 1;
            }
            .entry-grid {
                display: flex;
                gap: 1rem;
            }
            @media (orientation: landscape) {
                .entry-grid { flex-direction: row; }
            }
            @media (orientation: portrait) {
                .entry-grid { flex-direction: column; align-items: center; }
            }
        </style>
        <header class="bg-white shadow-sm shrink-0">
            <div class="max-w-3xl mx-auto px-4 py-3 text-center">
                <h1 class="text-3xl font-display font-bold text-primary tracking-tight">LUWENE</h1>
                <p class="text-warm-500 text-sm">Ayam Goreng Nikmat</p>
            </div>
        </header>

        <main class="flex-1 flex items-center justify-center px-4 overflow-hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="absolute top-4 left-1/2 -translate-x-1/2 p-2 bg-red-50 text-red-600 rounded-xl text-xs text-center z-10">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$orderMode): ?>
                <div class="text-center">
                    <h2 class="text-xl font-display font-bold text-dark mb-4">Mau Pesan?</h2>

                    <div class="entry-grid">
                        <button
                            wire:click="selectDelivery"
                            class="entry-card bg-white border-2 border-green-500 rounded-2xl p-4 text-center hover:bg-green-50 transition group flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-green-500 mx-auto mb-2 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                            <h3 class="text-lg font-bold text-dark">Delivery</h3>
                            <p class="text-xs text-warm-500 mt-0.5">Pesanan diantar ke alamatmu</p>
                        </button>

                        <button
                            wire:click="selectDineIn"
                            class="entry-card bg-white border-2 border-primary rounded-2xl p-4 text-center hover:bg-primary/5 transition group flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-primary mx-auto mb-2 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            <h3 class="text-lg font-bold text-dark">Makan di Sini</h3>
                            <p class="text-xs text-warm-500 mt-0.5">Pilih meja dan nikmati di tempat</p>
                        </button>

                        <button
                            wire:click="selectTakeAway"
                            class="entry-card bg-white border-2 border-warm-200 rounded-2xl p-4 text-center hover:border-accent hover:bg-accent/5 transition group flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-accent mx-auto mb-2 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <h3 class="text-lg font-bold text-dark">Bawa Pulang</h3>
                            <p class="text-xs text-warm-500 mt-0.5">Pesanan dibungkus untuk dibawa</p>
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="w-full max-w-2xl">
                    <button wire:click="$set('orderMode', '')" class="mb-3 text-warm-400 hover:text-dark transition flex items-center gap-1 text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </button>

                    <h2 class="text-lg font-display font-bold text-dark mb-3">Pilih Meja</h2>

                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <button
                                wire:click="selectTable('<?php echo e($table->id); ?>')"
                                <?php if($table->status !== 'AVAILABLE'): echo 'disabled'; endif; ?>
                                class="aspect-square rounded-xl border-2 p-2 flex flex-col items-center justify-center transition text-sm
                                    <?php if($table->status === 'AVAILABLE'): ?>
                                        border-warm-200 bg-white hover:border-primary hover:bg-primary/5 cursor-pointer
                                    <?php else: ?>
                                        border-warm-100 bg-warm-50 opacity-50 cursor-not-allowed
                                    <?php endif; ?>">
                                <span class="text-lg font-bold <?php echo e($table->status === 'AVAILABLE' ? 'text-dark' : 'text-warm-300'); ?>">
                                    <?php echo e($table->table_number); ?>

                                </span>
                                <span class="text-[10px] <?php echo e($table->status === 'AVAILABLE' ? 'text-warm-400' : 'text-warm-300'); ?>">
                                    <?php echo e($table->capacity); ?>pk
                                </span>
                                <span class="mt-0.5 w-1.5 h-1.5 rounded-full <?php echo e($table->status === 'AVAILABLE' ? 'bg-green-400' : 'bg-red-400'); ?>"></span>
                            </button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </main>

        <footer class="p-2 text-center text-[10px] text-warm-300 shrink-0">
            &copy; <?php echo e(date('Y')); ?> LUWENE
        </footer>
    </div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/entry-page.blade.php ENDPATH**/ ?>