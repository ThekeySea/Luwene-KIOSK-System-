<div>
<p class="text-sm text-gray-400 mb-4">{{ $customerCount }} akun pelanggan terdaftar</p>

<div class="flex gap-2 mb-4">
    @foreach (['' => 'Semua', 'CASHIER' => 'Kasir', 'ADMIN' => 'Admin'] as $value => $label)
        <button wire:click="$set('roleFilter', '{{ $value }}')" class="px-4 py-2 rounded-lg text-xs font-semibold transition {{ $roleFilter === $value ? 'bg-primary text-white' : 'bg-white border border-gray-200 text-gray-600 hover:text-gray-900' }}">{{ $label }}</button>
    @endforeach
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[640px]">
            <thead>
                <tr class="text-left text-xs uppercase tracking-wide text-gray-400 border-b border-gray-100">
                    <th class="px-4 py-3 font-medium">Nama</th>
                    <th class="px-4 py-3 font-medium">Role</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($staff as $member)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-900">{{ $member->name }}@if($member->id === auth()->id()) <span class="text-xs text-primary">(kamu)</span>@endif</p>
                            <p class="text-xs text-gray-400">{{ $member->email }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $member->role === 'ADMIN' ? 'bg-primary/10 text-primary' : 'bg-blue-100 text-blue-700' }}">{{ $member->role }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <button wire:click="toggleStatus('{{ $member->id }}')" class="text-xs px-2.5 py-1 rounded-full font-medium transition {{ ($member->status ?? 'ACTIVE') === 'ACTIVE' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                {{ ($member->status ?? 'ACTIVE') === 'ACTIVE' ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="openEdit('{{ $member->id }}')" class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-200 transition">Edit</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">Belum ada staff.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($showModal)
    <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" wire:click="$set('showModal', false)"></div>
        <div class="relative w-full max-w-md bg-white rounded-xl shadow-xl p-6">
            <h2 class="font-display font-bold text-gray-900 text-lg mb-4">{{ $editingId ? 'Edit Staff' : 'Tambah Staff' }}</h2>
            <form wire:submit="save">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama</label>
                        <input type="text" wire:model="name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Email</label>
                        <input type="email" wire:model="email" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Password {{ $editingId ? '(kosongkan bila tidak diubah)' : '' }}</label>
                        <input type="password" wire:model="password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Role</label>
                            <select wire:model="role" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none">
                                <option value="CASHIER">Kasir</option>
                                <option value="ADMIN">Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                            <select wire:model="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none">
                                <option value="ACTIVE">Aktif</option>
                                <option value="INACTIVE">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-2 mt-6">
                    <button type="button" wire:click="$set('showModal', false)" class="flex-1 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" wire:loading.attr="disabled" class="flex-1 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition disabled:opacity-50">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endif
</div>
