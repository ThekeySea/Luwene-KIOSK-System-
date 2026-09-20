<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUWENE Staff</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-dvh font-sans">
    <?php if (isset($component)) { $__componentOriginal23c7e14da05bcafd9d1a48017f320a55 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23c7e14da05bcafd9d1a48017f320a55 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.loading-bar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loading-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23c7e14da05bcafd9d1a48017f320a55)): ?>
<?php $attributes = $__attributesOriginal23c7e14da05bcafd9d1a48017f320a55; ?>
<?php unset($__attributesOriginal23c7e14da05bcafd9d1a48017f320a55); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23c7e14da05bcafd9d1a48017f320a55)): ?>
<?php $component = $__componentOriginal23c7e14da05bcafd9d1a48017f320a55; ?>
<?php unset($__componentOriginal23c7e14da05bcafd9d1a48017f320a55); ?>
<?php endif; ?>
    <?php echo e($slot); ?>

    <div
        x-data="{ toasts: [], push(message, type) { const id = Date.now() + Math.random(); this.toasts.push({ id, message, type: type || 'info' }); setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 4000); }, dismiss(id) { this.toasts = this.toasts.filter(t => t.id !== id); } }"
        @toast.window="push($event.detail.message, $event.detail.type)"
        class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-full max-w-sm px-4 space-y-2"
        aria-live="polite"
    >
        <template x-for="toast in toasts" :key="toast.id">
            <div
                class="flex items-start gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-medium text-white"
                :class="toast.type === 'success' ? 'bg-green-600' : (toast.type === 'error' ? 'bg-red-600' : 'bg-gray-800')"
            >
                <span class="flex-1" x-text="toast.message"></span>
                <button @click="dismiss(toast.id)" class="opacity-70 hover:opacity-100 transition shrink-0" aria-label="Tutup">&#10005;</button>
            </div>
        </template>
    </div>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\Luwene\resources\views/components/layouts/staff.blade.php ENDPATH**/ ?>