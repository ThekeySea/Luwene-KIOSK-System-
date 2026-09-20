<div>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
    @forelse ($branches as $branch)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="min-w-0">
                        <h2 class="font-display font-bold text-gray-900 text-lg">{{ $branch->name }}</h2>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $branch->address ?? 'Belum ada alamat' }}</p>
                    </div>
                    <button wire:click="toggleStatus('{{ $branch->id }}')" class="shrink-0 text-xs px-2.5 py-1 rounded-full font-medium transition {{ ($branch->status ?? 'ACTIVE') === 'ACTIVE' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                        {{ ($branch->status ?? 'ACTIVE') === 'ACTIVE' ? 'Aktif' : 'Nonaktif' }}
                    </button>
                </div>

                <div class="grid grid-cols-3 gap-3 mb-4">
                    <div class="bg-gray-50 rounded-lg p-3 text-center border border-gray-100">
                        <p class="text-lg font-bold text-gray-900">{{ $branch->tables_count }}</p>
                        <p class="text-xs text-gray-400">Meja</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 text-center border border-gray-100">
                        <p class="text-lg font-bold text-gray-900">{{ $branch->users_count }}</p>
                        <p class="text-xs text-gray-400">Staff</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 text-center border border-gray-100">
                        <p class="text-lg font-bold text-gray-900">{{ $branch->orders_count }}</p>
                        <p class="text-xs text-gray-400">Order</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button wire:click="openTables('{{ $branch->id }}')" class="flex-1 py-2 bg-primary/10 text-primary text-xs font-semibold rounded-lg hover:bg-primary/20 transition">Kelola Meja</button>
                    <button wire:click="openEdit('{{ $branch->id }}')" class="flex-1 py-2 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-200 transition">Edit</button>
                    @if(($branch->users_count ?? 0) === 0 && ($branch->orders_count ?? 0) === 0)
                        <button wire:click="$set('confirmingDelete', '{{ $branch->id }}')" class="py-2 px-3 bg-red-50 text-red-600 text-xs font-semibold rounded-lg hover:bg-red-100 transition">Hapus</button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 text-center">
            <div class="text-4xl mb-3">&#127978;</div>
            <p class="text-gray-400 text-sm">Belum ada cabang.</p>
            <button wire:click="openCreate" class="mt-3 px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition">Tambah Cabang Pertama</button>
        </div>
    @endforelse
</div>

@if($showModal)
    <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" wire:click="$set('showModal', false)"></div>
        <div class="relative w-full max-w-md bg-white rounded-xl shadow-xl p-6">
            <h2 class="font-display font-bold text-gray-900 text-lg mb-4">{{ $editingId ? 'Edit Cabang' : 'Tambah Cabang' }}</h2>
            <form wire:submit="save">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama Cabang</label>
                        <input type="text" wire:model="name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="Contoh: LUWENE Main" />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Alamat</label>
                        <input type="text" wire:model="address" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="Opsional" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                        <select wire:model="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none">
                            <option value="ACTIVE">Aktif</option>
                            <option value="INACTIVE">Nonaktif</option>
                        </select>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mt-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Pengiriman</p>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Latitude</label>
                                <input type="text" wire:model="latitude" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="-7.xxx" />
                                @error('latitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Longitude</label>
                                <input type="text" wire:model="longitude" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="112.xxx" />
                                @error('longitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mt-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Biaya Ongkir (Rp)</label>
                                <input type="number" wire:model="delivery_fee" min="0" step="500" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                                @error('delivery_fee') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Estimasi (menit)</label>
                                <input type="number" wire:model="estimated_delivery_minutes" min="5" max="120" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                                @error('estimated_delivery_minutes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
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
            <div class="text-4xl mb-3">&#128465;&#65039;</div>
            <h3 class="font-display font-bold text-gray-900 text-lg">Hapus cabang?</h3>
            <p class="text-sm text-gray-500 mt-2">Semua meja di cabang ini akan ikut terhapus.</p>
            <div class="flex gap-2 mt-5">
                <button wire:click="$set('confirmingDelete', null)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button wire:click="destroy('{{ $confirmingDelete }}')" class="flex-1 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">Hapus</button>
            </div>
        </div>
    </div>
@endif

@if($showTableModal)
    <div class="fixed inset-0 z-40 flex items-center justify-end">
        <div class="absolute inset-0 bg-black/40" wire:click="$set('showTableModal', false)"></div>
        <div class="relative w-full max-w-md h-full bg-white shadow-xl p-6 overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display font-bold text-gray-900 text-lg">Kelola Meja</h2>
                <button wire:click="$set('showTableModal', false)" class="text-gray-400 hover:text-gray-900 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="mb-4">
                @if($editingTableId)
                    <form wire:submit="saveTable" class="bg-gray-50 rounded-lg border border-gray-200 p-4 space-y-3">
                        <h3 class="text-sm font-semibold text-gray-900">{{ $editingTableId === '__new__' ? 'Tambah Meja' : 'Edit Meja' }}</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Nomor</label>
                                <input type="number" wire:model="tableNumber" min="1" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                                @error('tableNumber') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Kapasitas</label>
                                <input type="number" wire:model="tableCapacity" min="1" max="50" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Status</label>
                            <select wire:model="tableStatus" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none">
                                <option value="AVAILABLE">Tersedia</option>
                                <option value="OCCUPIED">Ditempati</option>
                                <option value="RESERVED">Direservasi</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" wire:click="$set('editingTableId', null)" class="flex-1 py-2 bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-300 transition">Batal</button>
                            <button type="submit" class="flex-1 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary-700 transition">Simpan</button>
                        </div>
                    </form>
                @else
                    <button wire:click="openCreateTable" class="w-full py-3 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition">+ Tambah Meja</button>
                @endif
            </div>

            <div class="space-y-2">
                @forelse ($tables as $table)
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg border border-gray-200 px-4 py-3">
                        <div class="flex items-center gap-3">
                            <span class="text-lg font-bold text-gray-900">M{{ $table->table_number }}</span>
                            <div>
                                <p class="text-xs text-gray-400">Kapasitas: {{ $table->capacity }} orang</p>
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                    {{ $table->status === 'AVAILABLE' ? 'bg-green-100 text-green-700' : ($table->status === 'OCCUPIED' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $table->status }}
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <button wire:click="openEditTable('{{ $table->id }}')" class="p-2 text-gray-400 hover:text-gray-900 transition rounded-lg hover:bg-gray-100">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                            </button>
                            @if($table->status !== 'OCCUPIED')
                                <button wire:click="deleteTable('{{ $table->id }}')" wire:confirm="Hapus meja M{{ $table->table_number }}?" class="p-2 text-gray-400 hover:text-red-600 transition rounded-lg hover:bg-gray-100">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">Belum ada meja. Klik "Tambah Meja" untuk menambahkan.</p>
                @endforelse
            </div>
        </div>
    </div>
@endif
</div>
