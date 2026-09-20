<div>
<div class="mb-6">
    <button wire:click="openCreate" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition">+ Tambah Kategori</button>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="divide-y divide-gray-100">
        @forelse ($categories as $category)
            <div class="px-5 py-4 flex items-center gap-4 hover:bg-gray-50 transition">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                    <p class="text-xs text-gray-400">{{ $category->slug }} &middot; {{ $category->products_count }} produk &middot; Urutan {{ $category->sort_order }}</p>
                </div>
                @unless($category->is_active)
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-gray-100 text-gray-500">Nonaktif</span>
                @endunless
                @if($category->is_published)
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-blue-100 text-blue-700">Published</span>
                @else
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-yellow-100 text-yellow-700">Draft</span>
                @endif
                <div class="flex gap-2 shrink-0">
                    @if($category->is_published)
                        <button wire:click="unpublish('{{ $category->id }}')" class="px-3 py-1.5 bg-yellow-50 text-yellow-700 text-xs font-medium rounded-lg hover:bg-yellow-100 transition">Unpublish</button>
                    @else
                        <button wire:click="$set('confirmingPublish', '{{ $category->id }}')" class="px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg hover:bg-blue-100 transition">Publish</button>
                    @endif
                    <button wire:click="openEdit('{{ $category->id }}')" class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-200 transition">Edit</button>
                    <button wire:click="$set('confirmingDelete', '{{ $category->id }}')" class="px-3 py-1.5 bg-red-50 text-red-600 text-xs font-medium rounded-lg hover:bg-red-100 transition">Hapus</button>
                </div>
            </div>
        @empty
            <div class="px-5 py-12 text-center text-gray-400 text-sm">Belum ada kategori.</div>
        @endforelse
    </div>
</div>

@if($showModal)
    <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" wire:click="$set('showModal', false)"></div>
        <div class="relative w-full max-w-md bg-white rounded-xl shadow-xl p-6">
            <h2 class="font-display font-bold text-gray-900 text-lg mb-4">{{ $editingId ? 'Edit Kategori' : 'Tambah Kategori' }}</h2>
            <form wire:submit="save">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama</label>
                        <input type="text" wire:model="name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="Ayam" />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                        <textarea wire:model="description" rows="2" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Urutan</label>
                        <input type="number" wire:model="sort_order" min="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700"><input type="checkbox" wire:model="is_active" class="w-4 h-4 accent-primary rounded" /> Aktif</label>
                </div>
                <div class="flex gap-2 mt-6">
                    <button type="button" wire:click="$set('showModal', false)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" wire:loading.attr="disabled" class="flex-1 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition disabled:opacity-50">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endif

@if($confirmingDelete)
    <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" wire:click="$set('confirmingDelete', null)"></div>
        <div class="relative w-full max-w-sm bg-white rounded-xl shadow-xl p-6 text-center">
            <h2 class="font-display font-bold text-gray-900 text-lg">Hapus kategori?</h2>
            <p class="text-sm text-gray-500 mt-1">Hanya bisa dihapus bila tidak punya produk.</p>
            <div class="flex gap-2 mt-5">
                <button wire:click="$set('confirmingDelete', null)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button wire:click="destroy('{{ $confirmingDelete }}')" class="flex-1 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">Ya, Hapus</button>
            </div>
        </div>
    </div>
@endif

@if($confirmingPublish)
    <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" wire:click="$set('confirmingPublish', null)"></div>
        <div class="relative w-full max-w-sm bg-white rounded-xl shadow-xl p-6 text-center">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
            </div>
            <h2 class="font-display font-bold text-gray-900 text-lg">Publish kategori ini?</h2>
            <p class="text-sm text-gray-500 mt-1">Kategori dan produk di dalamnya akan tampil di kiosk. Pastikan semua sudah benar.</p>
            <div class="flex gap-2 mt-5">
                <button wire:click="$set('confirmingPublish', null)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button wire:click="publish('{{ $confirmingPublish }}')" class="flex-1 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">Ya, Publish</button>
            </div>
        </div>
    </div>
@endif
</div>
