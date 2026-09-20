<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUWENE Staff</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-dvh font-sans">
    <x-loading-bar />
    {{ $slot }}
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
    @livewireScripts
</body>
</html>
