<?php

namespace App\Livewire\Customer;

use App\Models\Product;
use App\Models\Sambal;
use App\Models\SpiceLevel;
use Livewire\Component;

class ProductDetailPage extends Component
{
    public string $slug = '';
    public ?array $product = null;
    public ?string $selectedVariantId = null;
    public ?string $selectedNasiId = null;
    public ?string $selectedSambalId = null;
    public ?string $selectedLevelId = null;
    public array $selectedExtras = [];
    public int $quantity = 1;
    public string $notes = '';
    public array $sambals = [];
    public array $spiceLevels = [];
    public ?string $error = null;

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        $product = Product::with(['category', 'variants', 'modifierGroups.modifiers'])
            ->where('is_active', true)
            ->where('slug', $slug)
            ->first();

        if (!$product) {
            abort(404);
        }

        $this->product = $product->toArray();

        $this->sambals = Sambal::where('is_active', true)
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->get()
            ->toArray();

        $this->spiceLevels = SpiceLevel::where('is_active', true)
            ->orderBy('level_number')
            ->get()
            ->toArray();

        if (count($this->product['variants']) === 1) {
            $this->selectedVariantId = $this->product['variants'][0]['id'];
        }
    }

    public function selectVariant(string $id): void
    {
        $this->selectedVariantId = $id;
        $this->selectedNasiId = null;
        $this->selectedExtras = [];
    }

    public function selectNasi(string $id): void
    {
        $this->selectedNasiId = $id;
    }

    public function selectSambal(string $id): void
    {
        $this->selectedSambalId = $id;
    }

    public function selectLevel(string $id): void
    {
        $this->selectedLevelId = $id;
    }

    public function toggleExtra(string $id): void
    {
        if (in_array($id, $this->selectedExtras)) {
            $this->selectedExtras = array_diff($this->selectedExtras, [$id]);
        } else {
            $this->selectedExtras[] = $id;
        }
    }

    public function incrementQty(): void
    {
        if ($this->quantity < 20) {
            $this->quantity++;
        }
    }

    public function decrementQty(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart(): void
    {
        if (!$this->selectedVariantId) {
            $this->error = 'Pilih tipe pesanan terlebih dahulu.';
            return;
        }

        $variant = collect($this->product['variants'])->firstWhere('id', $this->selectedVariantId);
        if (!$variant) {
            $this->error = 'Variant tidak valid.';
            return;
        }

        if ($variant['name'] === 'Paket Nasi' && !$this->selectedNasiId) {
            $this->error = 'Pilih jenis nasi.';
            return;
        }

        if (!$this->selectedSambalId) {
            $this->error = 'Pilih sambal.';
            return;
        }

        if (!$this->selectedLevelId) {
            $this->error = 'Pilih level pedas.';
            return;
        }

        $sambal = collect($this->sambals)->firstWhere('id', $this->selectedSambalId);
        $level = collect($this->spiceLevels)->firstWhere('id', $this->selectedLevelId);

        $modifiers = [
            ['type' => 'sambal', 'id' => $sambal['id'], 'name' => $sambal['name'], 'price' => $sambal['price']],
            ['type' => 'spice_level', 'id' => $level['id'], 'name' => $level['name'], 'level' => $level['level_number'], 'price' => 0],
        ];

        if ($variant['name'] === 'Paket Nasi' && $this->selectedNasiId) {
            $nasiMod = collect($this->product['modifier_groups'] ?? $this->product['modifierGroups'] ?? [])
                ->where('name', 'Pilihan Nasi')
                ->first();
            if ($nasiMod) {
                $nasi = collect($nasiMod['modifiers'])->firstWhere('id', $this->selectedNasiId);
                if ($nasi) {
                    $modifiers[] = ['type' => 'nasi', 'id' => $nasi['id'], 'name' => $nasi['name'], 'price' => $nasi['price']];
                }
            }
        }

        if (!empty($this->selectedExtras)) {
            foreach ($this->selectedExtras as $extraId) {
                foreach ($this->product['modifier_groups'] ?? $this->product['modifierGroups'] ?? [] as $group) {
                    $extra = collect($group['modifiers'])->firstWhere('id', $extraId);
                    if ($extra) {
                        $modifiers[] = ['type' => 'extra', 'id' => $extra['id'], 'name' => $extra['name'], 'price' => $extra['price']];
                        break;
                    }
                }
            }
        }

        $unitPrice = $variant['price'];
        $modifierTotal = collect($modifiers)->sum('price');
        $itemSubtotal = ($unitPrice + $modifierTotal) * $this->quantity;

        $cartItem = [
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'product_id' => $this->product['id'],
            'product_name' => $this->product['name'],
            'variant_id' => $variant['id'],
            'variant_name' => $variant['name'],
            'unit_price' => $unitPrice,
            'modifiers' => $modifiers,
            'quantity' => $this->quantity,
            'notes' => $this->notes,
            'subtotal' => $itemSubtotal,
        ];

        $cart = session('cart', []);
        $cart[] = $cartItem;
        session(['cart' => $cart]);

        $this->dispatch('cartUpdated');
        $this->dispatch('showToast', 'Item ditambahkan ke keranjang');
        $this->redirectRoute('customer.menu');
    }

    public function render()
    {
        return view('livewire.customer.product-detail-page')->layout('layouts.customer');
    }
}
