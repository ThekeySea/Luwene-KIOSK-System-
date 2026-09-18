<div class="min-h-dvh bg-warm-50">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="<?php echo e(route('customer.cart')); ?>" class="text-warm-400 hover:text-dark transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-lg font-display font-bold text-dark">Data Diri</h1>
            <div class="w-6"></div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto p-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasItems): ?>
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-display font-bold text-dark text-lg">Siapa yang memesan?</h2>
                <p class="text-xs text-warm-400 mt-1 mb-5">Tanpa daftar akun. Data ini dicatat bersama pesananmu.</p>

                <form wire:submit="save">
                    <div class="space-y-4">
                        <div>
                            <label for="customer-name" class="block text-sm font-medium text-warm-700 mb-1">Nama Lengkap</label>
                            <input
                                type="text"
                                wire:model="name"
                                id="customer-name"
                                class="w-full px-4 py-3 bg-warm-50 border border-warm-200 rounded-xl text-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                                placeholder="Nama kamu"
                                autocomplete="name"
                            />
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label for="customer-email" class="block text-sm font-medium text-warm-700 mb-1">Email</label>
                            <input
                                type="email"
                                wire:model="email"
                                id="customer-email"
                                class="w-full px-4 py-3 bg-warm-50 border border-warm-200 rounded-xl text-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                                placeholder="email@contoh.com"
                                autocomplete="email"
                            />
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label for="customer-phone" class="block text-sm font-medium text-warm-700 mb-1">Nomor Telepon / WhatsApp</label>
                            <input
                                type="tel"
                                wire:model="phone"
                                id="customer-phone"
                                class="w-full px-4 py-3 bg-warm-50 border border-warm-200 rounded-xl text-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                                placeholder="08xxxxxxxxxx"
                                autocomplete="tel"
                            />
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full mt-6 py-4 text-lg bg-primary text-white font-semibold rounded-xl hover:bg-primary-700 transition"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50"
                    >
                        <span wire:loading.remove>Lanjut ke Pembayaran</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="text-center py-16">
                <p class="text-5xl mb-4">🧺</p>
                <h2 class="text-lg font-display font-bold text-dark mb-2">Nampan Kosong</h2>
                <p class="text-sm text-warm-500 mb-4">Isi dulu nampanmu sebelum isi data diri.</p>
                <a href="<?php echo e(route('customer.menu')); ?>" class="inline-block px-6 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-700 transition">
                    Lihat Menu
                </a>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </main>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/info.blade.php ENDPATH**/ ?>