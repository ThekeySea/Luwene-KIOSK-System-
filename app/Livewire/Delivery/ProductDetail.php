<?php

namespace App\Livewire\Delivery;

use App\Models\Product;
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $product;
    public string $selectedVariant = '';
    public string $selectedNasi = '';
    public string $selectedSambal = '';
    public string $selectedSpiceLevel = '';
    public array $selectedExtras = [];
    public int $quantity = 1;

    protected function rules(): array
    {
        return [
            'selectedVariant' => $this->product->variants->count() > 0 ? 'required' : 'nullable',
            'selectedNasi' => $this->showNasi && $this->nasiIsRequired ? 'required' : 'nullable',
            'selectedSambal' => $this->hasSambal && $this->sambalIsRequired ? 'required' : 'nullable',
            'selectedSpiceLevel' => $this->selectedSambal && $this->currentSambal?->spiceLevels->count() > 0 ? 'required' : 'nullable',
            'quantity' => 'required|min:1|max:20',
        ];
    }

    public function getShowNasiProperty(): bool
    {
        if (!$this->product->modifierGroups->contains('type', 'NASI')) {
            return false;
        }
        $variant = $this->product->variants->firstWhere('id', $this->selectedVariant);
        return !$variant || $variant->code !== 'ALA_CARTE';
    }

    public function getNasiIsRequiredProperty(): bool
    {
        $nasiGroup = $this->product->modifierGroups->firstWhere('type', 'NASI');
        return $nasiGroup ? (bool) $nasiGroup->pivot->is_required : false;
    }

    public function getHasSambalProperty(): bool
    {
        return $this->product->sambals->count() > 0;
    }

    public function getSambalIsRequiredProperty(): bool
    {
        return $this->product->sambals->contains('pivot.is_required', true);
    }

    public function getCurrentSambalProperty()
    {
        if (empty($this->selectedSambal)) {
            return null;
        }
        return $this->product->sambals->firstWhere('id', $this->selectedSambal);
    }

    public function mount(string $slug): void
    {
        $this->product = Product::with([
            'category',
            'variants',
            'sambals.spiceLevels',
            'modifierGroups.modifiers',
        ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->where('is_published_delivery', true)
            ->firstOrFail();

        if ($this->product->variants->count() > 0) {
            $this->selectedVariant = $this->product->variants->first()->id;
        }
    }

    public function getVariantPriceProperty(): float
    {
        $variant = $this->product->variants->firstWhere('id', $this->selectedVariant);
        return $variant ? (float) $variant->price : (float) $this->product->base_price;
    }

    public function getNasiPriceProperty(): float
    {
        if (empty($this->selectedNasi)) {
            return 0;
        }
        $nasiGroup = $this->product->modifierGroups->firstWhere('type', 'NASI');
        if (!$nasiGroup) {
            return 0;
        }
        $modifier = $nasiGroup->modifiers->firstWhere('id', $this->selectedNasi);
        return $modifier ? (float) $modifier->price : 0;
    }

    public function getSambalPriceProperty(): float
    {
        $sambal = $this->currentSambal;
        if (!$sambal) {
            return 0;
        }
        return (float) $sambal->pivot->price;
    }

    public function getExtrasTotalProperty(): float
    {
        $total = 0;
        $extraGroup = $this->product->modifierGroups->firstWhere('type', 'EXTRA');
        if ($extraGroup) {
            foreach ($extraGroup->modifiers as $modifier) {
                if (in_array($modifier->id, $this->selectedExtras)) {
                    $total += (float) $modifier->price;
                }
            }
        }
        return $total;
    }

    public function getTotalPriceProperty(): float
    {
        return ($this->variantPrice + $this->nasiPrice + $this->sambalPrice + $this->extrasTotal) * $this->quantity;
    }

    public function updatedSelectedSambal(): void
    {
        $this->selectedSpiceLevel = '';
    }

    public function updatedSelectedVariant(): void
    {
        if (!$this->showNasi) {
            $this->selectedNasi = '';
        }
    }

    public function addToCart()
    {
        $this->validate();

        $variant = $this->product->variants->firstWhere('id', $this->selectedVariant);
        $sambal = $this->currentSambal;
        $spiceLevel = $sambal?->spiceLevels->firstWhere('id', $this->selectedSpiceLevel);

        $nasiGroup = $this->product->modifierGroups->firstWhere('type', 'NASI');
        $nasiModifier = $nasiGroup?->modifiers->firstWhere('id', $this->selectedNasi);

        $extras = [];
        $extraGroup = $this->product->modifierGroups->firstWhere('type', 'EXTRA');
        if ($extraGroup) {
            foreach ($extraGroup->modifiers as $modifier) {
                if (in_array($modifier->id, $this->selectedExtras)) {
                    $extras[] = [
                        'id' => $modifier->id,
                        'name' => $modifier->name,
                        'price' => (float) $modifier->price,
                        'type' => 'EXTRA',
                    ];
                }
            }
        }

        $modifiers = [];
        if ($this->showNasi && $nasiModifier) {
            $modifiers[] = ['id' => $nasiModifier->id, 'name' => $nasiModifier->name, 'price' => (float) $nasiModifier->price, 'type' => 'NASI'];
        }
        if ($sambal) {
            $modifiers[] = ['id' => $sambal->id, 'name' => $sambal->name, 'price' => (float) $sambal->pivot->price, 'type' => 'SAMBAL'];
        }
        if ($spiceLevel) {
            $modifiers[] = ['id' => $spiceLevel->id, 'name' => $spiceLevel->name, 'price' => 0, 'type' => 'SPICE_LEVEL'];
        }
        $modifiers = array_merge($modifiers, $extras);

        $unitPrice = $this->variantPrice + $this->nasiPrice + $this->sambalPrice + $this->extrasTotal;

        $cartItem = [
            'id' => uniqid(),
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'variant' => $variant ? ['id' => $variant->id, 'name' => $variant->name, 'price' => (float) $variant->price] : null,
            'modifiers' => $modifiers,
            'quantity' => $this->quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $unitPrice * $this->quantity,
        ];

        $cart = session('delivery_cart', []);
        $cart[] = $cartItem;
        session()->put('delivery_cart', $cart);

        return redirect()->route('delivery.home');
    }

    public function render()
    {
        $nasiGroup = $this->product->modifierGroups->firstWhere('type', 'NASI');
        $extraGroup = $this->product->modifierGroups->firstWhere('type', 'EXTRA');
        $sambals = $this->product->sambals;
        $spiceLevels = $this->currentSambal?->spiceLevels ?? collect();

        return view('livewire.delivery.product-detail', [
            'nasiGroup' => $nasiGroup,
            'extraGroup' => $extraGroup,
            'sambals' => $sambals,
            'spiceLevels' => $spiceLevels,
            'showNasi' => $this->showNasi,
            'nasiIsRequired' => $this->nasiIsRequired,
            'sambalIsRequired' => $this->sambalIsRequired,
            'variantPrice' => $this->variantPrice,
            'nasiPrice' => $this->nasiPrice,
            'extrasTotal' => $this->extrasTotal,
            'totalPrice' => $this->totalPrice,
        ])->layout('components.layouts.delivery');
    }
}
