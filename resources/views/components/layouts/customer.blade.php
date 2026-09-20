<!DOCTYPE html>
<html lang="id" class="kiosk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'LUWENE')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-warm-50 text-dark antialiased min-h-dvh font-sans">
    {{ $slot }}
    @if($showNav ?? true)
        @php
            $navCartCount = session('cart') ? count(session('cart')) : 0;
            $isHome = request()->routeIs('home');
            $isMenu = request()->routeIs('customer.menu', 'customer.menu.category');
            $isCart = request()->routeIs('customer.cart');
            $isPromo = request()->routeIs('customer.promo');
            $isFaq = request()->routeIs('customer.faq');
        @endphp
        <div class="h-28" aria-hidden="true"></div>
        <nav class="fixed bottom-0 left-0 right-0 z-30 px-4" style="padding-bottom: calc(env(safe-area-inset-bottom) + 0.75rem);">
            <div class="max-w-lg mx-auto bg-white rounded-full border border-warm-100 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] px-2 py-2 grid grid-cols-5 items-center">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-0.5 py-1 transition {{ $isHome ? 'text-primary' : 'text-warm-400 hover:text-warm-600' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                    </svg>
                    <span class="text-xs {{ $isHome ? 'font-bold' : 'font-medium' }}">Beranda</span>
                </a>
                <a href="{{ route('customer.menu') }}" class="flex flex-col items-center gap-0.5 py-1 transition {{ $isMenu ? 'text-primary' : 'text-warm-400 hover:text-warm-600' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <span class="text-xs {{ $isMenu ? 'font-bold' : 'font-medium' }}">Menu</span>
                </a>
                <a href="{{ route('customer.cart') }}" class="flex flex-col items-center" aria-label="Nampan">
                    <span class="relative -mt-8 w-14 h-14 rounded-full text-white flex items-center justify-center shadow-lg ring-4 ring-warm-50 transition {{ $isCart ? 'bg-accent' : 'bg-primary hover:bg-primary-700' }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                        </svg>
                        @if($navCartCount > 0)
                            <span class="absolute -top-1 -right-1 min-w-6 h-6 px-1.5 bg-accent text-white text-xs font-bold rounded-full flex items-center justify-center ring-2 ring-white {{ $isCart ? 'bg-dark' : '' }}">{{ $navCartCount > 99 ? '99+' : $navCartCount }}</span>
                        @endif
                    </span>
                    <span class="text-xs mt-1 {{ $isCart ? 'font-bold text-primary' : 'font-medium text-warm-500' }}">Nampan</span>
                </a>
                <a href="{{ route('customer.promo') }}" class="flex flex-col items-center gap-0.5 py-1 transition {{ $isPromo ? 'text-primary' : 'text-warm-400 hover:text-warm-600' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                    </svg>
                    <span class="text-xs {{ $isPromo ? 'font-bold' : 'font-medium' }}">Promo</span>
                </a>
                <a href="{{ route('customer.faq') }}" class="flex flex-col items-center gap-0.5 py-1 transition {{ $isFaq ? 'text-primary' : 'text-warm-400 hover:text-warm-600' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                    <span class="text-xs {{ $isFaq ? 'font-bold' : 'font-medium' }}">FAQ</span>
                </a>
            </div>
        </nav>
    @endif
    <div
        x-data="{ toasts: [], push(message, type) { const id = Date.now() + Math.random(); this.toasts.push({ id, message, type: type || 'info' }); setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 4000); }, dismiss(id) { this.toasts = this.toasts.filter(t => t.id !== id); } }"
        @toast.window="push($event.detail.message, $event.detail.type)"
        class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-full max-w-sm px-4 space-y-2"
        aria-live="polite"
    >
        <template x-for="toast in toasts" :key="toast.id">
            <div
                class="flex items-start gap-3 px-4 py-3 rounded-2xl shadow-lg text-sm font-medium text-white"
                :class="toast.type === 'success' ? 'bg-green-600' : (toast.type === 'error' ? 'bg-red-600' : 'bg-dark-800')"
            >
                <span class="flex-1" x-text="toast.message"></span>
                <button @click="dismiss(toast.id)" class="opacity-70 hover:opacity-100 transition shrink-0" aria-label="Tutup">✕</button>
            </div>
        </template>
    </div>
    @livewireScripts
</body>
</html>
