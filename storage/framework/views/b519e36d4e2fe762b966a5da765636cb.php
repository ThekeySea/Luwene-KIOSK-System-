<div class="min-h-[calc(100dvh-64px)]">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('cashier.dashboard')); ?>" class="text-gray-400 hover:text-gray-900 transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-lg font-display font-bold text-gray-900">POS</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('cashier.scan')); ?>" class="text-sm font-medium text-primary hover:text-primary-700 transition">Scan</a>
                <span class="text-sm text-gray-500"><?php echo e(Auth::user()->name); ?></span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden" wire:poll.5s>
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-display font-bold text-gray-900">Pesanan Aktif</h2>
                <span class="flex items-center gap-1.5 text-[11px] font-medium text-green-600">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    Live
                </span>
            </div>
            <div class="divide-y divide-gray-100">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pendingOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $isDelivery = $order->order_mode === 'DELIVERY';
                        $borderColor = $isDelivery ? 'border-l-purple-500' : 'border-l-emerald-500';
                        $badgeBg = $isDelivery ? 'bg-purple-100 text-purple-700' : 'bg-emerald-100 text-emerald-700';
                        $badgeIcon = $isDelivery ? '🛵' : match($order->order_mode) {
                            'DINE_IN' => '🍽️',
                            'TAKEAWAY' => '📦',
                            default => '🛒',
                        };
                        $badgeLabel = $isDelivery ? 'Delivery' : match($order->order_mode) {
                            'DINE_IN' => 'Dine In',
                            'TAKEAWAY' => 'Bawa Pulang',
                            default => 'Kiosk',
                        };
                    ?>
                    <div class="px-5 py-4 border-l-4 <?php echo e($borderColor); ?>">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wide <?php echo e($badgeBg); ?> px-2 py-0.5 rounded-full">
                                        <?php echo e($badgeIcon); ?> <?php echo e($badgeLabel); ?>

                                    </span>
                                    <p class="text-sm font-bold text-gray-900">#<?php echo e($order->order_number); ?> &middot; <?php echo e($order->customer_name ?? 'Tanpa nama'); ?></p>
                                </div>
                                <p class="text-xs text-gray-400">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->order_mode === 'DINE_IN'): ?>
                                        Meja <?php echo e($order->table->table_number ?? '-'); ?>

                                    <?php elseif($order->order_mode === 'DELIVERY' && $order->driver_name): ?>
                                        Driver: <?php echo e($order->driver_name); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    &middot; <?php echo e($order->created_at->format('H:i')); ?>

                                </p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->order_mode === 'DELIVERY' && $order->delivery_address): ?>
                                    <p class="text-xs text-gray-400 mt-0.5">📍 <?php echo e(Str::limit($order->delivery_address, 60)); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-primary">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></p>
                                <span class="inline-block text-xs px-2 py-0.5 rounded-full font-medium
                                    <?php if($order->status === 'PENDING'): ?> bg-yellow-100 text-yellow-700
                                    <?php elseif($order->status === 'CONFIRMED'): ?> bg-blue-100 text-blue-700
                                    <?php elseif($order->status === 'PREPARING'): ?> bg-orange-100 text-orange-700
                                    <?php elseif($order->status === 'OUT_FOR_DELIVERY'): ?> bg-purple-100 text-purple-700
                                    <?php else: ?> bg-green-100 text-green-700
                                    <?php endif; ?>">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'OUT_FOR_DELIVERY'): ?> Sedang Dikirim
                                    <?php else: ?> <?php echo e($order->status); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            <?php ($nextLabel = match($order->status) {
                                'PENDING' => 'Konfirmasi',
                                'CONFIRMED' => 'Mulai Siapkan',
                                'PREPARING' => 'Tandai Siap',
                                'READY' => $order->order_mode === 'DELIVERY' ? 'Kirim' : 'Selesaikan',
                                'OUT_FOR_DELIVERY' => 'Terkirim',
                                default => null,
                            }); ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($nextLabel): ?>
                                <button
                                    wire:click="advance('<?php echo e($order->id); ?>')"
                                    wire:loading.attr="disabled"
                                    wire:target="advance('<?php echo e($order->id); ?>')"
                                    class="px-4 py-2 text-white text-xs font-semibold rounded-lg transition disabled:opacity-50
                                        <?php if($order->status === 'PENDING'): ?> bg-blue-500 hover:bg-blue-600
                                        <?php elseif($order->status === 'CONFIRMED'): ?> bg-orange-500 hover:bg-orange-600
                                        <?php elseif($order->status === 'OUT_FOR_DELIVERY'): ?> bg-purple-500 hover:bg-purple-600
                                        <?php else: ?> bg-green-500 hover:bg-green-600
                                        <?php endif; ?>">
                                    <span wire:loading.remove wire:target="advance('<?php echo e($order->id); ?>')"><?php echo e($nextLabel); ?></span>
                                    <span wire:loading wire:target="advance('<?php echo e($order->id); ?>')">Memproses...</span>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'PENDING'): ?>
                                <button
                                    wire:click="openCancelModal('<?php echo e($order->id); ?>')"
                                    class="px-4 py-2 text-red-600 text-xs font-semibold rounded-lg border border-red-200 hover:bg-red-50 transition">
                                    Batalkan
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="px-5 py-12 text-center text-gray-400 text-sm">Tidak ada pesanan aktif</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </main>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDriverModal): ?>
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click.self="$set('showDriverModal', false)">
            <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
                <h3 class="text-lg font-bold text-gray-900 mb-1">Data Driver</h3>
                <p class="text-sm text-gray-500 mb-4">Isi data driver untuk pengiriman delivery.</p>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Driver *</label>
                        <input type="text" wire:model="driverName" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Nama driver">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['driverName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP Driver</label>
                        <input type="text" wire:model="driverPhone" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary" placeholder="08xxx">
                    </div>
                </div>

                <div class="flex gap-2 mt-5">
                    <button wire:click="$set('showDriverModal', false)" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Batal</button>
                    <button wire:click="confirmAdvanceWithDriver" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-purple-500 text-white text-sm font-semibold rounded-lg hover:bg-purple-600 transition disabled:opacity-50">
                        <span wire:loading.remove>Kirim</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCancelModal): ?>
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click.self="$set('showCancelModal', false)">
            <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
                <h3 class="text-lg font-bold text-gray-900 mb-1">Batalkan Pesanan?</h3>
                <p class="text-sm text-gray-500 mb-5">Pesanan akan dibatalkan dan meja yang terkait akan dikembalikan ke status kosong.</p>
                <div class="flex gap-2">
                    <button wire:click="$set('showCancelModal', false)" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Kembali</button>
                    <button wire:click="confirmCancel" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-red-500 text-white text-sm font-semibold rounded-lg hover:bg-red-600 transition disabled:opacity-50">
                        <span wire:loading.remove>Ya, Batalkan</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/staff/pos.blade.php ENDPATH**/ ?>