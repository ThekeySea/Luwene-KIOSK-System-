<div class="min-h-dvh bg-warm-50 pb-8" x-data>
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3 flex items-center gap-3">
            <a href="<?php echo e(route('delivery.home')); ?>" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-sm font-bold text-dark">Profil Saya</h1>
        </div>
    </header>

    <main class="max-w-lg mx-auto px-4 py-4 space-y-4">

        
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-warm-100">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                    <span class="text-2xl font-bold text-primary"><?php echo e(substr($user->name, 0, 1)); ?></span>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="font-bold text-dark"><?php echo e($user->name); ?></h2>
                    <p class="text-sm text-warm-500 truncate"><?php echo e($user->email); ?></p>
                    <p class="text-xs text-warm-400 mt-0.5"><?php echo e($orderCount); ?> pesanan</p>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm border border-warm-100 divide-y divide-warm-100">
            <a href="<?php echo e(route('delivery.orders')); ?>" class="flex items-center gap-3 px-5 py-4 hover:bg-warm-50 transition">
                <span class="text-xl">📋</span>
                <span class="flex-1 text-sm font-medium text-dark">Riwayat Pesanan</span>
                <svg class="w-5 h-5 text-warm-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm border border-warm-100">
            <div class="flex items-center justify-between px-5 py-4 border-b border-warm-100">
                <h3 class="text-sm font-bold text-dark">Alamat Pengiriman</h3>
                <button wire:click="openAddModal" class="text-xs font-semibold text-primary hover:underline">+ Tambah</button>
            </div>
            <div class="divide-y divide-warm-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="px-5 py-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-dark"><?php echo e($addr->label); ?></span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($addr->is_default): ?>
                                        <span class="text-[10px] px-1.5 py-0.5 bg-primary/10 text-primary rounded-full font-medium">Utama</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <p class="text-xs text-warm-500 mt-0.5 leading-relaxed"><?php echo e($addr->address); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $addr->is_default): ?>
                                <button wire:click="setDefault('<?php echo e($addr->id); ?>')" class="text-[11px] text-warm-400 hover:text-primary transition">Jadikan Utama</button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span class="text-warm-200">|</span>
                            <button wire:click="openEditModal('<?php echo e($addr->id); ?>')" class="text-[11px] text-warm-400 hover:text-primary transition">Edit</button>
                            <span class="text-warm-200">|</span>
                            <button wire:click="confirmDelete('<?php echo e($addr->id); ?>')" class="text-[11px] text-warm-400 hover:text-red-500 transition">Hapus</button>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="px-5 py-8 text-center">
                        <p class="text-2xl mb-2">📍</p>
                        <p class="text-sm text-warm-400">Belum ada alamat tersimpan</p>
                        <button wire:click="openAddModal" class="mt-2 text-sm font-semibold text-primary hover:underline">Tambah Alamat</button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <form method="POST" action="<?php echo e(route('delivery.logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="w-full bg-white rounded-2xl p-4 shadow-sm border border-warm-100 text-red-500 font-semibold text-sm hover:bg-red-50 transition text-center">
                Keluar
            </button>
        </form>
    </main>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAddressModal): ?>
        <div class="fixed inset-0 z-50 flex items-end justify-center" x-data="{ open: true }" x-transition:enter="ease-out duration-200" x-transition:leave="ease-in duration-150">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('showAddressModal', false)"></div>
            <div class="relative bg-white rounded-t-2xl w-full max-w-lg p-5 pb-8 z-10" x-transition:enter="ease-out duration-200" x-transition:leave="ease-in duration-150">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-dark"><?php echo e($editingAddressId ? 'Edit Alamat' : 'Tambah Alamat'); ?></h3>
                    <button wire:click="$set('showAddressModal', false)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-warm-100 text-warm-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-medium text-warm-500 mb-1 block">Label</label>
                        <input wire:model="label" type="text" maxlength="50" placeholder="Rumah, Kantor, Kos, dll."
                            class="w-full border border-warm-200 rounded-xl px-3 py-2.5 text-sm text-dark placeholder:text-warm-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-0.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-warm-500 mb-1 block">Alamat Lengkap</label>
                        <textarea wire:model="address" rows="2" maxlength="255" placeholder="Jl. Nama Jalan No. 123, RT/RW, Kelurahan, Kecamatan"
                            class="w-full border border-warm-200 rounded-xl px-3 py-2.5 text-sm text-dark placeholder:text-warm-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary resize-none"></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-0.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-medium text-warm-500 mb-1 block">Latitude <span class="text-warm-300">(opsional)</span></label>
                            <input wire:model="latitude" type="text" placeholder="-7.xxx"
                                class="w-full border border-warm-200 rounded-xl px-3 py-2.5 text-sm text-dark placeholder:text-warm-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-0.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-warm-500 mb-1 block">Longitude <span class="text-warm-300">(opsional)</span></label>
                            <input wire:model="longitude" type="text" placeholder="112.xxx"
                                class="w-full border border-warm-200 rounded-xl px-3 py-2.5 text-sm text-dark placeholder:text-warm-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-0.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="isDefault" class="accent-primary rounded">
                        <span class="text-sm text-dark">Jadikan alamat utama</span>
                    </label>
                </div>

                <button wire:click="saveAddress" wire:loading.attr="disabled"
                    class="w-full mt-4 py-3 rounded-xl font-bold text-white text-sm bg-primary hover:bg-red-800 transition disabled:opacity-50">
                    <span wire:loading.remove wire:target="saveAddress"><?php echo e($editingAddressId ? 'Simpan Perubahan' : 'Tambah Alamat'); ?></span>
                    <span wire:loading wire:target="saveAddress">Menyimpan...</span>
                </button>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isDeleting): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="cancelDelete"></div>
            <div class="relative bg-white rounded-2xl p-5 w-full max-w-sm z-10 text-center">
                <p class="text-2xl mb-2">🗑️</p>
                <p class="text-sm font-bold text-dark mb-1">Hapus Alamat?</p>
                <p class="text-xs text-warm-400 mb-4">Alamat ini akan dihapus permanen.</p>
                <div class="flex gap-3">
                    <button wire:click="cancelDelete" class="flex-1 py-2.5 rounded-xl border border-warm-200 text-sm font-semibold text-warm-500 hover:bg-warm-50 transition">Batal</button>
                    <button wire:click="deleteAddress" class="flex-1 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">Hapus</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/delivery/profile.blade.php ENDPATH**/ ?>