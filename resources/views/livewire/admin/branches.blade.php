<div>
    @if($branch)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="font-display font-bold text-gray-900 text-xl">{{ $branch->name }}</h2>
                        <p class="text-sm text-gray-400 mt-0.5">{{ $branch->address ?? 'Belum ada alamat' }}</p>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $branch->status === 'ACTIVE' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $branch->status === 'ACTIVE' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-gray-50 rounded-lg p-3 text-center border border-gray-100">
                        <p class="text-lg font-bold text-gray-900">{{ $tableCount }}</p>
                        <p class="text-xs text-gray-400">Meja</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 text-center border border-gray-100">
                        <p class="text-lg font-bold text-gray-900">{{ $staffCount }}</p>
                        <p class="text-xs text-gray-400">Staff</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 text-center border border-gray-100">
                        <p class="text-lg font-bold text-gray-900">{{ $orderCount }}</p>
                        <p class="text-xs text-gray-400">Total Order</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 mt-4">
        <div class="p-6">
            <h3 class="font-display font-bold text-gray-900 text-lg mb-4">Edit Info Restoran</h3>
            <form wire:submit="save">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama Restoran</label>
                        <input type="text" wire:model="name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Alamat</label>
                        <input type="text" wire:model="address" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="Jl. ..." />
                    </div>
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
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Biaya Ongkir (Rp)</label>
                            <input type="number" wire:model="delivery_fee" min="0" step="500" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                            @error('delivery_fee') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Estimasi Pengiriman (menit)</label>
                            <input type="number" wire:model="estimated_delivery_minutes" min="5" max="120" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                            @error('estimated_delivery_minutes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" wire:loading.attr="disabled" class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition disabled:opacity-50">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SECTION: MANAJEMEN MEJA                                  --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-xl border border-gray-200 mt-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-display font-bold text-gray-900 text-lg">Manajemen Meja</h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    <span class="text-emerald-600 font-semibold">{{ $availableCount }}</span> kosong &middot;
                    <span class="text-red-500 font-semibold">{{ $occupiedCount }}</span> terpakai &middot;
                    {{ $tableCount }} total
                </p>
            </div>
            <div class="flex gap-2">
                <button wire:click="openBulk" class="px-3 py-2 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" /></svg>
                    Banyak
                </button>
                <button wire:click="openCreateTable" class="px-3 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary-700 transition flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Tambah
                </button>
            </div>
        </div>

        <div class="p-6">
            @if($tableCount > 0)
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2.5">
                    @foreach($tables as $table)
                        @php $isOccupied = $table->status === 'OCCUPIED'; @endphp
                        <div class="group relative border-2 rounded-2xl p-3 text-center transition-all duration-200
                            {{ $isOccupied
                                ? 'border-red-200 bg-gradient-to-b from-red-50 to-white'
                                : 'border-emerald-200 bg-gradient-to-b from-emerald-50 to-white hover:border-emerald-300 hover:shadow-sm' }}">

                            <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center mb-1.5
                                {{ $isOccupied ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5l16.5-4.5m0 0L21 11.25m-3.75-3.75v13.5m0 0L9 21m11.25-3.75L9 21" />
                                </svg>
                            </div>

                            <p class="text-sm font-display font-bold {{ $isOccupied ? 'text-red-700' : 'text-gray-900' }}">
                                {{ $table->table_number }}
                            </p>

                            <div class="flex items-center justify-center gap-0.5 mt-0.5">
                                <svg class="w-2.5 h-2.5 {{ $isOccupied ? 'text-red-400' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" />
                                </svg>
                                <span class="text-[10px] font-medium {{ $isOccupied ? 'text-red-500' : 'text-gray-500' }}">{{ $table->capacity }}</span>
                            </div>

                            <div class="mt-2 pt-2 border-t {{ $isOccupied ? 'border-red-100' : 'border-gray-100' }} flex gap-1.5">
                                <button wire:click="openEditTable('{{ $table->id }}')"
                                    class="flex-1 text-[10px] font-semibold py-1 rounded-md transition
                                    {{ $isOccupied ? 'text-red-600 bg-red-50 hover:bg-red-100' : 'text-gray-600 bg-gray-50 hover:bg-gray-100' }}">
                                    Edit
                                </button>
                                <button wire:click="$set('confirmingDeleteTable', '{{ $table->id }}')"
                                    class="flex-1 text-[10px] font-semibold text-red-600 bg-red-50 py-1 rounded-md hover:bg-red-100 transition">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 7.5l16.5-4.5m0 0L21 11.25m-3.75-3.75v13.5m0 0L9 21m11.25-3.75L9 21" />
                    </svg>
                    <p class="text-sm font-medium">Belum ada meja</p>
                    <p class="text-xs mt-1">Klik "Tambah" untuk membuat meja baru</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- MODALS                                                   --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}

    @if($showTableModal)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('showTableModal', false)"></div>
            <div class="relative w-full max-w-sm bg-white rounded-xl shadow-xl p-6">
                <h2 class="font-display font-bold text-gray-900 text-lg mb-4">{{ $editingTableId ? 'Edit Meja' : 'Tambah Meja' }}</h2>
                <form wire:submit="saveTable">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nomor Meja</label>
                            <input type="number" wire:model="table_number" min="1"
                                {{ $editingTableId ? 'disabled' : '' }}
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none disabled:opacity-50 disabled:cursor-not-allowed" placeholder="1" />
                            @error('table_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kapasitas (Orang)</label>
                            <input type="number" wire:model="capacity" min="1" max="100"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="4" />
                            @error('capacity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                            <select wire:model="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none">
                                <option value="AVAILABLE">Kosong</option>
                                <option value="OCCUPIED">Terpakai</option>
                                <option value="RESERVED">Direservasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-6">
                        <button type="button" wire:click="$set('showTableModal', false)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" wire:loading.attr="disabled" class="flex-1 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition disabled:opacity-50">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($confirmingDeleteTable)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('confirmingDeleteTable', null)"></div>
            <div class="relative w-full max-w-sm bg-white rounded-xl shadow-xl p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </div>
                <h2 class="font-display font-bold text-gray-900 text-lg">Hapus meja ini?</h2>
                <p class="text-sm text-gray-500 mt-1">Hanya bisa dihapus jika tidak ada riwayat pesanan.</p>
                <div class="flex gap-2 mt-5">
                    <button wire:click="$set('confirmingDeleteTable', null)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                    <button wire:click="destroyTable('{{ $confirmingDeleteTable }}')" class="flex-1 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">Ya, Hapus</button>
                </div>
            </div>
        </div>
    @endif

    @if($showBulkModal)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('showBulkModal', false)"></div>
            <div class="relative w-full max-w-sm bg-white rounded-xl shadow-xl p-6">
                <h2 class="font-display font-bold text-gray-900 text-lg mb-4">Tambah Banyak Meja</h2>
                <form wire:submit="saveBulk">
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Mulai dari</label>
                                <input type="number" wire:model="bulkStart" min="1"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Sampai</label>
                                <input type="number" wire:model="bulkEnd" min="1"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kapasitas per Meja (Orang)</label>
                            <input type="number" wire:model="bulkCapacity" min="1" max="100"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="4" />
                        </div>
                        @php
                            $start = (int) $bulkStart;
                            $end = (int) $bulkEnd;
                            $count = $end >= $start ? $end - $start + 1 : 0;
                        @endphp
                        @if($count > 0)
                            <p class="text-xs text-gray-500 bg-gray-50 rounded-lg px-3 py-2">
                                Akan membuat <span class="font-semibold text-gray-700">{{ $count }} meja</span>
                                (Nomor {{ $start }}–{{ $end }}, kapasitas {{ $bulkCapacity }} orang)
                            </p>
                        @endif
                    </div>
                    <div class="flex gap-2 mt-6">
                        <button type="button" wire:click="$set('showBulkModal', false)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" wire:loading.attr="disabled" class="flex-1 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition disabled:opacity-50">Buat Semua</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
