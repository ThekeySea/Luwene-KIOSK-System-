<?php

namespace App\Livewire\Customer;

use App\Models\Product;
use App\Models\Sambal;
use App\Models\SpiceLevel;
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $product;
    public string $selectedVariant = '';
    public string $selectedSambal = '';
    public string $selectedSpiceLevel = '';
    public array $selectedExtras = [];
    public int $quantity = 1;

    public string $sambalName = '';
    public string $spiceLevelName = '';

    protected function rules(): array
    {
        $isFood = in_array($this->product->category->slug ?? '', ['ayam', 'daging', 'seafood']);

        return [
            'selectedVariant' => $this->product->variants->count() > 0 ? 'required' : 'nullable',
            'selectedSambal' => $isFood ? 'required' : 'nullable',
            'selectedSpiceLevel' => $isFood ? 'required' : 'nullable',
            'quantity' => 'required|min:1|max:20',
        ];
    }

    public function getRequiresConfigProperty(): bool
    {
        return in_array($this->product->category->slug ?? '', ['ayam', 'daging', 'seafood']);
    }

    public function mount(string $slug): void
    {
        $this->product = Product::with(['category', 'variants', 'modifierGroups.modifiers'])
            ->where('slug', $slug)
            ->where('is_active', true)
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

    public function getSambalPriceProperty(): float
    {
        if (empty($this->selectedSambal)) {
            return 0;
        }

        $sambal = Sambal::find($this->selectedSambal);

        return $sambal ? (float) $sambal->price : 0;
    }

    public function getTotalPriceProperty(): float
    {
        return ($this->variantPrice + $this->sambalPrice + $this->extrasTotal) * $this->quantity;
    }

    public function addToCart()
    {
        $this->validate();

        $variant = $this->product->variants->firstWhere('id', $this->selectedVariant);
        $sambal = Sambal::find($this->selectedSambal);
        $spiceLevel = SpiceLevel::find($this->selectedSpiceLevel);

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
        if ($sambal) {
            $modifiers[] = ['id' => $sambal->id, 'name' => $sambal->name, 'price' => (float) $sambal->price, 'type' => 'SAMBAL'];
        }
        if ($spiceLevel) {
            $modifiers[] = ['id' => $spiceLevel->id, 'name' => $spiceLevel->name, 'price' => 0, 'type' => 'SPICE_LEVEL'];
        }
        $modifiers = array_merge($modifiers, $extras);

        $unitPrice = $this->variantPrice + $this->sambalPrice + $this->extrasTotal;

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

        $cart = session('cart', []);
        $cart[] = $cartItem;
        session()->put('cart', $cart);

        return redirect()->route('customer.cart');
    }

    public function render()
    {
        $sambals = Sambal::where('is_active', true)->get();
        $spiceLevels = SpiceLevel::where('is_active', true)->orderBy('level')->get();

        $extraGroup = $this->product->modifierGroups->firstWhere('type', 'EXTRA');

        return view('livewire.customer.product-detail', [
            'sambals' => $sambals,
            'spiceLevels' => $spiceLevels,
            'extraGroup' => $extraGroup,
            'variantPrice' => $this->variantPrice,
            'extrasTotal' => $this->extrasTotal,
            'totalPrice' => $this->totalPrice,
            'requiresConfig' => $this->requiresConfig,
        ])->layout('components.layouts.customer', ['showNav' => false]);
    }
}
