<div>
<div class="mb-6">
    <button wire:click="openCreate" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition">+ Tambah Promo</button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    @forelse ($promos as $promo)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="font-mono font-bold text-primary text-lg">{{ $promo->code }}</p>
                    <p class="text-sm text-gray-900 font-medium mt-0.5">{{ $promo->name }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $promo->label() }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Min. Rp {{ number_format($promo->min_order_amount, 0, ',', '.') }} &middot; Terpakai {{ $promo->used_count }}{{ $promo->usage_limit ? '/'.$promo->usage_limit : '' }}</p>
                    @if($promo->starts_at || $promo->ends_at)
                        <p class="text-xs text-gray-400">{{ $promo->starts_at?->format('d M Y') ?? '...' }} &#8211; {{ $promo->ends_at?->format('d M Y') ?? '...' }}</p>
                    @endif
                </div>
                <button wire:click="toggleActive('{{ $promo->id }}')" class="text-xs px-2.5 py-1 rounded-full font-medium transition shrink-0 {{ $promo->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                    {{ $promo->is_active ? 'Aktif' : 'Mati' }}
                </button>
            </div>
            <div class="flex gap-2 mt-4">
                <button wire:click="openEdit('{{ $promo->id }}')" class="flex-1 py-2 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-200 transition">Edit</button>
                <button wire:click="$set('confirmingDelete', '{{ $promo->id }}')" class="flex-1 py-2 bg-red-50 text-red-600 text-xs font-semibold rounded-lg hover:bg-red-100 transition">Hapus</button>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-xl border border-gray-200 px-5 py-12 text-center text-gray-400 text-sm">Belum ada promo.</div>
    @endforelse
</div>

@if($showModal)
    <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" wire:click="$set('showModal', false)"></div>
        <div class="relative w-full max-w-lg bg-white rounded-xl shadow-xl p-6 max-h-[90dvh] overflow-y-auto">
            <h2 class="font-display font-bold text-gray-900 text-lg mb-4">{{ $editingId ? 'Edit Promo' : 'Tambah Promo' }}</h2>
            <form wire:submit="save">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kode</label>
                            <input type="text" wire:model="code" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 font-mono uppercase focus:ring-2 focus:ring-primary outline-none" placeholder="HEMAT10" />
                            @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tipe</label>
                            <select wire:model="type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none">
                                <option value="FIXED">Nominal (Rp)</option>
                                <option value="PERCENT">Persen (%)</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama</label>
                        <input type="text" wire:model="name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nilai</label>
                            <input type="number" wire:model="value" min="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                            @error('value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Min. Belanja</label>
                            <input type="number" wire:model="min_order_amount" min="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Maks. Diskon</label>
                            <input type="number" wire:model="max_discount_amount" min="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="Opsional" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Mulai</label>
                            <input type="date" wire:model="starts_at" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Berakhir</label>
                            <input type="date" wire:model="ends_at" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kuota</label>
                            <input type="number" wire:model="usage_limit" min="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="&#8734;" />
                        </div>
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
            <h2 class="font-display font-bold text-gray-900 text-lg">Hapus promo?</h2>
            <div class="flex gap-2 mt-5">
                <button wire:click="$set('confirmingDelete', null)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button wire:click="destroy('{{ $confirmingDelete }}')" class="flex-1 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">Ya, Hapus</button>
            </div>
        </div>
    </div>
@endif
</div>
