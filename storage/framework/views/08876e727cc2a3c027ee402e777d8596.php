<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | LUWENE</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-warm-50 text-dark min-h-dvh flex items-center justify-center font-sans">
    <div class="text-center px-6">
        <div class="text-7xl mb-4">🍗</div>
        <h1 class="text-6xl font-display font-bold text-primary mb-2">404</h1>
        <p class="text-lg text-warm-600 mb-6">Halaman yang kamu cari tidak ditemukan.</p>
        <a href="<?php echo e(route('home')); ?>" class="inline-block px-8 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-700 transition">Kembali ke Beranda</a>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\Luwene\resources\views/errors/404.blade.php ENDPATH**/ ?>