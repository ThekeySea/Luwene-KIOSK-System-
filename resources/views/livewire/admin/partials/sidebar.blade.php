<div x-data="{ mobileOpen: false }" class="contents">
    <button @click="mobileOpen = !mobileOpen" class="md:hidden fixed bottom-4 left-4 z-50 w-12 h-12 bg-dark-900 border border-dark-700 rounded-full shadow-lg flex items-center justify-center text-warm-300 hover:text-white transition">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="mobileOpen = false" class="md:hidden fixed inset-0 z-40 bg-black/60"></div>

    <aside class="hidden md:block w-60 shrink-0 self-start sticky top-24" :class="{ 'fixed inset-y-0 left-0 z-50 w-60 p-4 md:p-0 md:relative md:inset-auto': mobileOpen }" x-show="$el.classList.contains('fixed') ? mobileOpen : true" x-transition>
        <div class="bg-dark-900 rounded-2xl border border-dark-800 p-3 space-y-1">
            @php($adminNav = [
                ['route' => 'admin.dashboard', 'label' => 'Dashboard'],
                ['route' => 'admin.products', 'label' => 'Produk'],
                ['route' => 'admin.categories', 'label' => 'Kategori'],
                ['route' => 'admin.promos', 'label' => 'Promo'],
                ['route' => 'admin.branches', 'label' => 'Info Restoran'],
                ['route' => 'admin.staff', 'label' => 'Staff'],
                ['route' => 'admin.transactions', 'label' => 'Transaksi'],
                ['route' => 'admin.reports', 'label' => 'Laporan'],
                ['route' => 'admin.settings', 'label' => 'Pengaturan'],
            ])
            @foreach ($adminNav as $item)
                <a href="{{ route($item['route']) }}" @click="mobileOpen = false" class="block px-4 py-2.5 rounded-xl text-sm transition {{ request()->routeIs($item['route']) ? 'bg-primary text-white font-bold' : 'text-warm-300 hover:bg-dark-800 hover:text-white' }}">{{ $item['label'] }}</a>
            @endforeach
        </div>
    </aside>
</div>
