<div>
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500">Kelola pilihan nasi dan tambahan (addon)</p>
        <button wire:click="openCreate" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition">
            + Tambah Grup
        </button>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Nama</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Tipe</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Item</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Wajib</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Produk</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($groups as $group)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ $group->name }}</div>
                                @if ($group->description)
                                    <div class="text-xs text-gray-400 mt-0.5">{{ Str::limit($group->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($group->type === 'NASI')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Nasi</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Add-on</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600">{{ $group->modifiers_count }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($group->is_required)
                                    <span class="text-green-600 text-xs font-medium">Ya</span>
                                @else
                                    <span class="text-gray-400 text-xs">Tidak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600">{{ $group->products_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="openEdit('{{ $group->id }}')" class="px-2 py-1 text-xs text-blue-600 rounded-lg hover:bg-blue-50 transition">Edit</button>
                                    <button wire:click="$set('confirmingDelete', '{{ $group->id }}')" class="px-2 py-1 text-xs text-red-600 rounded-lg hover:bg-red-50 transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada grup modifier</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Create / Edit Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data>
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 rounded-t-2xl">
                    <h3 class="text-lg font-bold text-gray-900">{{ $editingId ? 'Edit Grup' : 'Tambah Grup' }}</h3>
                </div>

                <form wire:submit.prevent="save" class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Grup</label>
                        <input type="text" wire:model="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" placeholder="Pilihan Nasi">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea wire:model="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" placeholder="Opsional"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                            <select wire:model="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition">
                                <option value="NASI">Nasi</option>
                                <option value="EXTRA">Add-on</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                            <input type="number" wire:model="sort_order" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Wajib Dipilih</label>
                            <select wire:model="is_required" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Minimal</label>
                            <input type="number" wire:model="min_selection" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition">
                        </div>
                    </div>

                    {{-- Inline Modifiers --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Item dalam Grup</label>

                        @if (count($modifiers) > 0)
                            <div class="space-y-2 mb-3">
                                @foreach ($modifiers as $i => $mod)
                                    <div class="flex items-center gap-2 bg-gray-50 rounded-lg px-3 py-2">
                                        <span class="flex-1 text-sm text-gray-700">{{ $mod['name'] }}</span>
                                        <span class="text-sm text-gray-500">
                                            {{ $mod['price'] > 0 ? '+Rp ' . number_format((float)$mod['price'], 0, ',', '.') : 'Gratis' }}
                                        </span>
                                        <button type="button" wire:click="removeModifier({{ $i }})" class="text-red-400 hover:text-red-600 transition text-xs">Hapus</button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex gap-2">
                            <input type="text" wire:model="newModifierName" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" placeholder="Nama item">
                            <input type="number" wire:model="newModifierPrice" min="0" class="w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" placeholder="Harga">
                            <button type="button" wire:click="addModifier" class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition shrink-0">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 transition">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition" wire:loading.attr="disabled" wire:loading.class="opacity-50">
                            <span wire:loading.remove>Simpan</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation --}}
    @if ($confirmingDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data>
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('confirmingDelete', null)"></div>
            <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Grup?</h3>
                <p class="text-sm text-gray-500 mb-6">Semua item dalam grup ini akan dihapus.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('confirmingDelete', null)" class="flex-1 px-4 py-2 text-sm text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">Batal</button>
                    <button wire:click="destroy('{{ $confirmingDelete }}')" class="flex-1 px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700 transition">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>
