<div class="min-h-dvh flex flex-col bg-warm-50">
    <header class="bg-white shadow-sm shrink-0">
        <div class="max-w-lg mx-auto px-4 py-3 flex items-center gap-3">
            <a href="<?php echo e(route('delivery.entry')); ?>" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-warm-100 text-warm-500 hover:text-dark transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-display font-bold text-dark">Daftar Delivery</h1>
                <p class="text-xs text-warm-400">Buat akun untuk mulai pesan</p>
            </div>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-sm">
            <form wire:submit.prevent="register" class="space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                    <div class="bg-red-50 border border-red-200 rounded-xl p-3 text-sm text-red-600">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div>
                    <label class="block text-sm font-medium text-dark mb-1.5">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="w-full border border-warm-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" placeholder="Nama Anda">
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark mb-1.5">Email</label>
                    <input type="email" wire:model="email" class="w-full border border-warm-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" placeholder="email@contoh.com" autocomplete="email">
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark mb-1.5">No. HP</label>
                    <input type="text" wire:model="phone" class="w-full border border-warm-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" placeholder="08xxx">
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark mb-1.5">Password</label>
                    <input type="password" wire:model="password" class="w-full border border-warm-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" placeholder="Minimal 8 karakter" autocomplete="new-password">
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark mb-1.5">Konfirmasi Password</label>
                    <input type="password" wire:model="password_confirmation" class="w-full border border-warm-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" placeholder="Ulangi password" autocomplete="new-password">
                </div>

                <button type="submit" class="w-full py-3.5 bg-primary text-white font-semibold rounded-xl hover:bg-primary-700 transition disabled:opacity-50" wire:loading.attr="disabled">
                    <span wire:loading.remove>Daftar</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </form>

            <p class="text-center text-sm text-warm-500 mt-6">
                Sudah punya akun?
                <a href="<?php echo e(route('delivery.login')); ?>" class="text-primary font-semibold hover:underline">Masuk</a>
            </p>
        </div>
    </main>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/delivery/register.blade.php ENDPATH**/ ?>