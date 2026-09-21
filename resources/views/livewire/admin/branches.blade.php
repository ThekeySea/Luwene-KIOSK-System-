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

                <div class="grid grid-cols-3 gap-3 mb-6">
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
</div>
