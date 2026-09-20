<div>
<form wire:submit="save" class="max-w-2xl space-y-6">
    <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
        <h2 class="font-display font-bold text-gray-900">Pajak & Nomor Order</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Tarif Pajak (PPN) %</label>
                <input type="number" wire:model="tax_rate" min="0" max="100" step="0.5" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                <p class="text-xs text-gray-400 mt-1">Saat ini: {{ $tax_rate }}% (default 11%)</p>
                @error('tax_rate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Prefix Nomor Order</label>
                <input type="text" wire:model="order_prefix" maxlength="10" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none uppercase" placeholder="LW" />
                <p class="text-xs text-gray-400 mt-1">Contoh: {{ $order_prefix }}-00001</p>
                @error('order_prefix') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
        <h2 class="font-display font-bold text-gray-900">Jam Operasional</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Buka</label>
                <input type="time" wire:model="opening_hours" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                @error('opening_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Tutup</label>
                <input type="time" wire:model="closing_hours" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none" />
                @error('closing_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
        <h2 class="font-display font-bold text-gray-900">Struk</h2>

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Footer Struk</label>
            <textarea wire:model="receipt_footer" rows="2" maxlength="255" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-primary outline-none resize-none" placeholder="Terima kasih telah memesan di LUWENE!"></textarea>
            @error('receipt_footer') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" wire:loading.attr="disabled" class="px-8 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition disabled:opacity-50">Simpan Pengaturan</button>
    </div>
</form>
</div>
