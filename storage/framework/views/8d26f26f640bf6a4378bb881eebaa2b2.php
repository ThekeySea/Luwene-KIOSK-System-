<div class="min-h-dvh flex flex-col bg-warm-50">
    <header class="bg-white shadow-sm shrink-0">
        <div class="max-w-lg mx-auto px-4 py-3 text-center">
            <h1 class="text-2xl font-display font-bold text-primary tracking-tight">LUWENE</h1>
            <p class="text-warm-500 text-xs">Delivery</p>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center px-4">
        <div class="w-full max-w-sm text-center space-y-6">
            <div>
                <span class="text-6xl block mb-4">🚗</span>
                <h2 class="text-xl font-display font-bold text-dark">Pesan & Antar</h2>
                <p class="text-sm text-warm-500 mt-2">Makanan favoritmu diantar ke alamatmu</p>
            </div>

            <div class="space-y-3">
                <a href="<?php echo e(route('delivery.login')); ?>" class="block w-full py-3.5 bg-primary text-white font-semibold rounded-xl hover:bg-primary-700 transition text-center">
                    Masuk
                </a>
                <a href="<?php echo e(route('delivery.register')); ?>" class="block w-full py-3.5 border-2 border-warm-200 text-dark font-semibold rounded-xl hover:border-primary hover:bg-primary/5 transition text-center">
                    Buat Akun Baru
                </a>
            </div>

            <a href="<?php echo e(route('home')); ?>" class="inline-block text-sm text-warm-400 hover:text-dark transition">
                Kembali ke Beranda
            </a>
        </div>
    </main>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/delivery/entry-page.blade.php ENDPATH**/ ?>