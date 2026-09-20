<div>
<div class="flex flex-col sm:flex-row gap-3 mb-6">
    <button wire:click="openCreate" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition">+ Tambah Paket</button>
    <input type="text" wire:model.live.debounce.300ms="search" class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition" placeholder="Cari paket..." />
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[720px]">
            <thead>
                <tr class="text-left text-xs uppercase tracking-wide text-gray-400 border-b border-gray-100">
                    <th class="px-4 py-3 font-medium">Paket</th>
                    <th class="px-4 py-3 font-medium">Tipe</th>
                    <th class="px-4 py-3 font-medium">Item</th>
                    <th class="px-4 py-3 font-medium text-right">Harga</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($packages as $pkg)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-lg bg-gray-100 overflow-hidden flex items-center justify-center shrink-0">
                                    @if($pkg->image)
                                        <img src="{{ asset('storage/'.$pkg->image) }}" alt="{{ $pkg->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-lg">&#127873;</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">{{ $pkg->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $pkg->code }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $pkg->type === 'MODULAR' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $pkg->type === 'MODULAR' ? 'Modular' : 'Tetap' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $pkg->items_count }} item</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">{{ $pkg->type === 'FIXED' ? 'Rp '.number_format($pkg->price, 0, ',', '.') : 'Dihitung' }}</td>
                        <td class="px-4 py-3">
                            @if($pkg->is_published)
                                <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-blue-100 text-blue-700">Published</span>
                            @else
                                <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-yellow-100 text-yellow-700">Draft</span>
                            @endif
                            @if($pkg->is_published_delivery)
                                <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-green-100 text-green-700 ml-1">🛵 Delivery</span>
                            @endif
                            <button wire:click="toggleActive('{{ $pkg->id }}')" class="text-xs px-2.5 py-1 rounded-full font-medium transition {{ $pkg->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} ml-1">
                                {{ $pkg->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                @if($pkg->is_published)
                                    <button wire:click="unpublish('{{ $pkg->id }}')" class="px-3 py-1.5 bg-yellow-50 text-yellow-700 text-xs font-medium rounded-lg hover:bg-yellow-100 transition">Unpublish</button>
                                @else
                                    <button wire:click="$set('confirmingPublish', '{{ $pkg->id }}')" class="px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg hover:bg-blue-100 transition">Publish</button>
                                @endif
                                <button wire:click="openEdit('{{ $pkg->id }}')" class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-200 transition">Edit</button>
                                <button wire:click="$set('confirmingDelete', '{{ $pkg->id }}')" class="px-3 py-1.5 bg-red-50 text-red-600 text-xs font-medium rounded-lg hover:bg-red-100 transition">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-12 text-center text-gray-400">Belum ada paket. Buat paket pertama.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($showModal)
    <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" wire:click="$set('showModal', false)"></div>
        <div class="relative w-full max-w-2xl bg-white rounded-xl shadow-xl p-6 max-h-[90dvh] overflow-y-auto">
            <h2 class="font-display font-bold text-gray-900 text-lg mb-4">{{ $editingId ? 'Edit Paket' : 'Tambah Paket' }}</h2>
            <form wire:submit="save">
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-600 text-xs font-semibold mb-1">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside text-red-500 text-xs space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Paket</label>
                            <input type="text" wire:model="name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="Paket Hemat Ayam" />
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kode</label>
                            <input type="text" wire:model="code" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" placeholder="PAKET_HEMAT" />
                            @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                        <textarea wire:model="description" rows="2" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tipe</label>
                            <select wire:model.live="type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none">
                                <option value="FIXED">Tetap</option>
                                <option value="MODULAR">Modular</option>
                            </select>
                        </div>
                        @if ($type === 'FIXED')
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Harga (Rp)</label>
                                <input type="number" wire:model="price" min="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Foto</label>
                            <input type="file" wire:model="photo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:px-4 file:py-2 file:rounded-lg file:border-0 file:bg-gray-100 file:text-gray-700 file:text-xs file:font-semibold hover:file:bg-gray-200 transition" />
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-700">
                        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" wire:model="is_active" class="w-4 h-4 accent-primary rounded" /> Aktif</label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" wire:model="is_published" class="w-4 h-4 accent-primary rounded" /> Published</label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" wire:model="is_published_delivery" class="w-4 h-4 accent-green-600 rounded" /> Tampilkan di Delivery</label>
                    </div>

                    {{-- Fixed Items --}}
                    @if ($type === 'FIXED')
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-semibold text-gray-700">Item Paket</label>
                                <button type="button" wire:click="addFixedItem" class="text-xs text-primary font-medium hover:underline">+ Tambah Item</button>
                            </div>
                            <div class="space-y-2">
                                @foreach ($fixedItems as $index => $item)
                                    <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg">
                                        <select wire:change="updateFixedItem({{ $index }}, 'product_id', $event.target.value)" class="flex-1 px-3 py-1.5 bg-white border border-gray-200 rounded text-xs text-gray-900 focus:ring-1 focus:ring-primary outline-none">
                                            <option value="" @selected($item['product_id'] === '')>Pilih produk</option>
                                            @foreach ($allProducts as $product)
                                                <option value="{{ $product->id }}" @selected($item['product_id'] === $product->id)>{{ $product->name }} — Rp {{ number_format($product->base_price, 0, ',', '.') }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number" wire:change="updateFixedItem({{ $index }}, 'quantity', $event.target.value)" value="{{ $item['quantity'] }}" min="1" class="w-16 px-2 py-1.5 bg-white border border-gray-200 rounded text-xs text-gray-900 focus:ring-1 focus:ring-primary outline-none text-center" placeholder="Qty" />
                                        <select wire:change="updateFixedItem({{ $index }}, 'role', $event.target.value)" class="w-24 px-2 py-1.5 bg-white border border-gray-200 rounded text-xs text-gray-900 focus:ring-1 focus:ring-primary outline-none">
                                            <option value="FIXED" @selected($item['role'] === 'FIXED')>Tetap</option>
                                            <option value="CHOICE" @selected($item['role'] === 'CHOICE')>Pilihan</option>
                                        </select>
                                        <input type="number" wire:change="updateFixedItem({{ $index }}, 'price_override', $event.target.value)" value="{{ $item['price_override'] }}" min="0" class="w-24 px-2 py-1.5 bg-white border border-gray-200 rounded text-xs text-gray-900 focus:ring-1 focus:ring-primary outline-none" placeholder="Harga" />
                                        <span class="text-xs text-gray-400">Rp</span>
                                        @if (count($fixedItems) > 1)
                                            <button type="button" wire:click="removeFixedItem({{ $index }})" class="text-red-400 hover:text-red-600 text-xs">&#10005;</button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @error('fixedItems') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    {{-- Modular Sections --}}
                    @if ($type === 'MODULAR')
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-semibold text-gray-700">Bagian Paket</label>
                                <button type="button" wire:click="addSection" class="text-xs text-primary font-medium hover:underline">+ Tambah Bagian</button>
                            </div>
                            <div class="space-y-3">
                                @foreach ($sections as $sIndex => $section)
                                    <div class="border border-gray-200 rounded-lg p-3">
                                        <div class="flex items-center gap-2 mb-2">
                                            <input type="text" wire:change="updateSection({{ $sIndex }}, 'name', $event.target.value)" value="{{ $section['name'] }}" class="flex-1 px-3 py-1.5 bg-gray-50 border border-gray-200 rounded text-xs text-gray-900 focus:ring-1 focus:ring-primary outline-none" placeholder="Nama bagian (contoh: Pilih Menu)" />
                                            <select wire:change="updateSection({{ $sIndex }}, 'choice_type', $event.target.value)" class="w-28 px-2 py-1.5 bg-gray-50 border border-gray-200 rounded text-xs text-gray-900 focus:ring-1 focus:ring-primary outline-none">
                                                <option value="SINGLE" @selected($section['choice_type'] === 'SINGLE')>Single</option>
                                                <option value="MULTIPLE" @selected($section['choice_type'] === 'MULTIPLE')>Multiple</option>
                                            </select>
                                            <input type="number" wire:change="updateSection({{ $sIndex }}, 'max_pick', $event.target.value)" value="{{ $section['max_pick'] }}" min="1" class="w-16 px-2 py-1.5 bg-gray-50 border border-gray-200 rounded text-xs text-gray-900 focus:ring-1 focus:ring-primary outline-none text-center" />
                                            <span class="text-xs text-gray-400">pilih</span>
                                            <button type="button" wire:click="removeSection({{ $sIndex }})" class="text-red-400 hover:text-red-600 text-xs">&#10005;</button>
                                        </div>
                                        <div class="space-y-1 ml-4">
                                            @foreach ($section['items'] as $iIndex => $item)
                                                <div class="flex items-center gap-2">
                                                    <select wire:change="updateSectionItem({{ $sIndex }}, {{ $iIndex }}, 'product_id', $event.target.value)" class="flex-1 px-3 py-1.5 bg-white border border-gray-200 rounded text-xs text-gray-900 focus:ring-1 focus:ring-primary outline-none">
                                                        <option value="" @selected($item['product_id'] === '')>Pilih produk</option>
                                                        @foreach ($allProducts as $product)
                                                            <option value="{{ $product->id }}" @selected($item['product_id'] === $product->id)>{{ $product->name }} — Rp {{ number_format($product->base_price, 0, ',', '.') }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="number" wire:change="updateSectionItem({{ $sIndex }}, {{ $iIndex }}, 'price_override', $event.target.value)" value="{{ $item['price_override'] }}" min="0" class="w-24 px-2 py-1.5 bg-white border border-gray-200 rounded text-xs text-gray-900 focus:ring-1 focus:ring-primary outline-none" placeholder="Harga" />
                                                    <span class="text-xs text-gray-400">Rp</span>
                                                    @if (count($section['items']) > 1)
                                                        <button type="button" wire:click="removeSectionItem({{ $sIndex }}, {{ $iIndex }})" class="text-red-400 hover:text-red-600 text-xs">&#10005;</button>
                                                    @endif
                                                </div>
                                            @endforeach
                                            <button type="button" wire:click="addSectionItem({{ $sIndex }})" class="text-xs text-primary font-medium hover:underline">+ Tambah Item</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('sections') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    @endif
                </div>
                <div class="flex gap-2 mt-6">
                    <button type="button" wire:click="$set('showModal', false)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" wire:loading.attr="disabled" class="flex-1 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition disabled:opacity-50">
                        <span wire:loading.remove wire:target="save,photo">Simpan</span>
                        <span wire:loading wire:target="save,photo">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

@if($confirmingDelete)
    <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" wire:click="$set('confirmingDelete', null)"></div>
        <div class="relative w-full max-w-sm bg-white rounded-xl shadow-xl p-6 text-center">
            <h2 class="font-display font-bold text-gray-900 text-lg">Arsipkan paket?</h2>
            <p class="text-sm text-gray-500 mt-1">Paket akan diarsipkan dan tidak tampil di kiosk.</p>
            <div class="flex gap-2 mt-5">
                <button wire:click="$set('confirmingDelete', null)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button wire:click="destroy('{{ $confirmingDelete }}')" class="flex-1 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">Ya, Arsipkan</button>
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
            <h2 class="font-display font-bold text-gray-900 text-lg">Publish paket ini?</h2>
            <p class="text-sm text-gray-500 mt-1">Paket akan tampil di halaman kiosk pelanggan.</p>
            <div class="flex gap-2 mt-5">
                <button wire:click="$set('confirmingPublish', null)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button wire:click="publish('{{ $confirmingPublish }}')" class="flex-1 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">Ya, Publish</button>
            </div>
        </div>
    </div>
@endif
</div>
