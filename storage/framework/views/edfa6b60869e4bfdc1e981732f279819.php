<div class="min-h-dvh bg-warm-50">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-3xl mx-auto px-4 py-4 text-center">
            <h1 class="text-lg font-display font-bold text-dark">Promo</h1>
            <p class="text-xs text-warm-400">Klaim voucher, hemat belanja</p>
        </div>
    </header>

    <main class="max-w-3xl mx-auto p-4 space-y-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($applied): ?>
            <div class="bg-green-50 border-2 border-green-500 rounded-2xl p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-green-600">Promo dipakai</p>
                        <p class="text-xl font-display font-bold text-dark mt-1"><?php echo e($applied->code); ?></p>
                        <p class="text-sm text-warm-600 mt-1"><?php echo e($applied->label()); ?></p>
                    </div>
                    <span class="text-3xl">🎟️</span>
                </div>
                <div class="mt-4 flex gap-2">
                    <a href="<?php echo e(route('customer.cart')); ?>" class="flex-1 py-2.5 bg-green-600 text-white text-sm text-center font-semibold rounded-xl hover:bg-green-700 transition">
                        Lihat Nampan
                    </a>
                    <button wire:click="remove" class="px-4 py-2.5 bg-white border border-warm-200 text-sm font-medium text-warm-600 rounded-xl hover:text-red-500 hover:border-red-300 transition">
                        Hapus
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <form wire:submit="apply">
                    <label for="promo-code" class="block text-sm font-semibold text-dark mb-2">Kode Promo / Voucher</label>
                    <div class="flex gap-2">
                        <input
                            type="text"
                            wire:model="code"
                            id="promo-code"
                            class="flex-1 min-w-0 px-4 py-3 bg-warm-50 border border-warm-200 rounded-xl text-dark font-mono font-bold uppercase tracking-widest placeholder:normal-case placeholder:font-sans placeholder:font-normal placeholder:tracking-normal focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                            placeholder="Contoh: HEMAT10"
                            autocomplete="off"
                        />
                        <button
                            type="submit"
                            class="px-6 py-3.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-700 transition shrink-0"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50"
                        >
                            <span wire:loading.remove wire:target="apply">Pakai</span>
                            <span wire:loading wire:target="apply">...</span>
                        </button>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </form>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <h2 class="font-semibold text-dark mb-3">Cara pakai promo</h2>
            <ol class="space-y-2.5 text-sm text-warm-600">
                <li class="flex gap-2.5">
                    <span class="w-6 h-6 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center justify-center shrink-0">1</span>
                    Isi nampan dengan menu favorit kamu
                </li>
                <li class="flex gap-2.5">
                    <span class="w-6 h-6 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center justify-center shrink-0">2</span>
                    Masukkan kode promo di kolom atas lalu tekan Pakai
                </li>
                <li class="flex gap-2.5">
                    <span class="w-6 h-6 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center justify-center shrink-0">3</span>
                    Potongan otomatis dihitung di Nampan &amp; Checkout
                </li>
            </ol>
            <p class="text-xs text-warm-400 mt-3">Satu kode promo per nampan. Promo tidak berlaku per menu, melainkan memotong total belanja.</p>
        </div>
    </main>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/promo.blade.php ENDPATH**/ ?>