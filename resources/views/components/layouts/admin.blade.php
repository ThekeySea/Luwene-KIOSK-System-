<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUWENE Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 antialiased font-sans">
    <x-loading-bar />
    <div
        x-data="{ mobileOpen: false }"
        @keydown.escape.window="mobileOpen = false"
        style="display: flex; height: 100vh; overflow: hidden;"
    >
        {{-- ═══ MOBILE BACKDROP ═══ --}}
        <div
            x-show="mobileOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="mobileOpen = false"
            class="lg:hidden fixed inset-0 z-[70] bg-black/50 backdrop-blur-sm"
            aria-hidden="true"
        ></div>

        {{-- ═══ SIDEBAR ═══ --}}
        <aside
            :class="mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            style="width: 240px; min-width: 240px; height: 100vh; flex-shrink: 0; overflow-y: auto;"
            class="
                fixed inset-y-0 left-0 z-[80]
                flex flex-col bg-dark-950
                transition-transform duration-200
                lg:static lg:z-auto
            "
            aria-label="Navigasi admin"
            role="navigation"
        >
            {{-- ── LOGO ── --}}
            <div style="height: 64px; min-height: 64px;" class="flex items-center justify-center gap-3 px-4 border-b border-white/10">
                <div class="w-9 h-9 rounded-lg bg-primary flex items-center justify-center shrink-0 shadow-lg shadow-primary/30">
                    <span class="text-white font-display font-bold text-sm">L</span>
                </div>
                <div class="hidden lg:block">
                    <p class="font-display font-bold text-white text-sm leading-tight">LUWENE</p>
                    <p class="text-[10px] text-white/40 leading-tight">Admin Panel</p>
                </div>
            </div>

            {{-- ── NAVIGATION ── --}}
            <nav class="flex-1 py-3 px-2 space-y-1 overflow-y-auto" aria-label="Menu admin">
                @php
                    $groups = [
                        [
                            'items' => [
                                ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />'],
                                ['route' => 'admin.transactions', 'label' => 'Transaksi', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />'],
                                ['route' => 'admin.products', 'label' => 'Produk', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />'],
                                ['route' => 'admin.categories', 'label' => 'Kategori', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6h.008v.008H6V6z" />'],
                                ['route' => 'admin.sambals', 'label' => 'Sambal', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />'],
                                ['route' => 'admin.modifier-groups', 'label' => 'Tambahan', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15" />'],
                                ['route' => 'admin.promos', 'label' => 'Promo', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />'],
                                ['route' => 'admin.branches', 'label' => 'Cabang', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016A3.001 3.001 0 0021 9.349" />'],
                                ['route' => 'admin.staff', 'label' => 'Staff', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />'],
                                ['route' => 'admin.reports', 'label' => 'Laporan', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />'],
                                ['route' => 'admin.settings', 'label' => 'Pengaturan', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />'],
                            ],
                        ],
                    ];
                @endphp

                @foreach ($groups[0]['items'] as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        @click="mobileOpen = false"
                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                            focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-dark-950
                            {{ request()->routeIs($item['route'])
                                ? 'bg-primary/20 text-white'
                                : 'text-white hover:bg-white/10'
                            }}"
                        aria-current="{{ request()->routeIs($item['route']) ? 'page' : 'false' }}"
                    >
                        @if(request()->routeIs($item['route']))
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-accent rounded-r-full" aria-hidden="true"></span>
                        @endif

                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs($item['route']) ? 'text-accent' : 'text-white/70 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $item['icon'] !!}
                        </svg>

                        <span class="whitespace-nowrap">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            {{-- ── USER / LOGOUT (pinned bottom) ── --}}
            <div style="min-height: 52px;" class="border-t border-white/10 p-3 shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/40 hover:text-red-400 hover:bg-white/10 transition focus:outline-none focus:ring-2 focus:ring-accent" aria-label="Keluar">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        <span class="hidden lg:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ═══ MOBILE HAMBURGER BUTTON ═══ --}}
        <button
            @click="mobileOpen = true"
            class="lg:hidden fixed top-4 left-4 z-[60] w-10 h-10 bg-white border border-gray-200 rounded-lg shadow-sm flex items-center justify-center text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
            aria-label="Buka menu"
        >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        {{-- ═══ KONTEN UTAMA (flex: 1, scroll mandiri) ═══ --}}
        <div style="flex: 1; min-width: 0; height: 100vh; overflow-y: auto; display: flex; flex-direction: column;">
            <header style="height: 64px; min-height: 64px;" class="bg-white border-b border-gray-200 flex items-center px-6 lg:px-8 shrink-0">
                <div class="lg:hidden w-10"></div>
                <h1 class="text-lg font-display font-bold text-gray-900">{{ $pageTitle ?? '' }}</h1>
                <div class="flex-1"></div>
                {!! $pageActions ?? '' !!}
            </header>

            <main class="flex-1 p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- ═══ TOAST NOTIFICATIONS ═══ --}}
    <div
        x-data="{ toasts: [], push(message, type) { const id = Date.now() + Math.random(); this.toasts.push({ id, message, type: type || 'info' }); setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 4000); }, dismiss(id) { this.toasts = this.toasts.filter(t => t.id !== id); } }"
        @toast.window="push($event.detail.message, $event.detail.type)"
        class="fixed top-4 right-4 z-[100] w-full max-w-sm px-4 space-y-2"
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
