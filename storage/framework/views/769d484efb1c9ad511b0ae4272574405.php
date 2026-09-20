    <div class="min-h-dvh flex items-center justify-center p-4">
        <div class="w-full max-w-lg">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-display font-bold text-primary tracking-tight">LUWENE</h1>
                <p class="text-warm-500 mt-2">Buat akun baru</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form wire:submit="register">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-warm-700 mb-1">Nama</label>
                            <input
                                type="text"
                                wire:model="name"
                                id="name"
                                class="w-full px-4 py-3 bg-warm-50 border border-warm-200 rounded-xl text-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                                placeholder="Nama lengkap"
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
                            <label for="email" class="block text-sm font-medium text-warm-700 mb-1">Email</label>
                            <input
                                type="email"
                                wire:model="email"
                                id="email"
                                class="w-full px-4 py-3 bg-warm-50 border border-warm-200 rounded-xl text-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                                placeholder="email@luwene.id"
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
                            <label for="password" class="block text-sm font-medium text-warm-700 mb-1">Password</label>
                            <input
                                type="password"
                                wire:model="password"
                                id="password"
                                class="w-full px-4 py-3 bg-warm-50 border border-warm-200 rounded-xl text-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                                placeholder="Minimal 8 karakter"
                            />
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-warm-700 mb-1">Konfirmasi Password</label>
                            <input
                                type="password"
                                wire:model="password_confirmation"
                                id="password_confirmation"
                                class="w-full px-4 py-3 bg-warm-50 border border-warm-200 rounded-xl text-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                                placeholder="Ulangi password"
                            />
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full mt-6 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 transition"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50"
                    >
                        <span wire:loading.remove>Daftar</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-warm-500">
                    Sudah punya akun?
                    <a href="<?php echo e(route('login')); ?>" class="text-primary font-semibold hover:underline">Masuk</a>
                </div>
            </div>
        </div>
    </div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/auth/register.blade.php ENDPATH**/ ?>