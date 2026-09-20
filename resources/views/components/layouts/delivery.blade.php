<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'LUWENE Delivery')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-warm-50 text-dark antialiased min-h-dvh font-sans">
    <form id="delivery-back-form" method="POST" action="{{ route('delivery.logout') }}" class="hidden">
        @csrf
    </form>
    <button type="button"
        onclick="document.getElementById('delivery-back-form').submit()"
        class="fixed top-3 left-3 z-[100] w-9 h-9 bg-white/80 backdrop-blur-sm rounded-full shadow-md flex items-center justify-center text-warm-500 hover:text-primary hover:shadow-lg hover:scale-105 transition-all duration-200 border border-warm-100"
        title="Kembali ke halaman awal">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
    {{ $slot }}
    @livewireScripts
</body>
</html>
