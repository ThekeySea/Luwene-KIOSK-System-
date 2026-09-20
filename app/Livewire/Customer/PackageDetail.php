<?php

namespace App\Livewire\Customer;

use App\Models\Package;
use Livewire\Component;

class PackageDetail extends Component
{
    public Package $package;
    public int $currentStep = 0;
    public array $selections = [];
    public int $quantity = 1;

    protected function rules(): array
    {
        $rules = [];

        if ($this->package->type === 'MODULAR') {
            foreach ($this->package->sections as $sIndex => $section) {
                $rules["selections.{$sIndex}"] = $section->choice_type === 'SINGLE'
                    ? 'required'
                    : 'required|array|min:1';
            }
        }

        $rules['quantity'] = 'required|min:1|max:20';

        return $rules;
    }

    public function mount(string $code): void
    {
        $this->package = Package::with([
            'items.product',
            'sections.items.product',
        ])
            ->where('code', $code)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        // Initialize selections for modular
        if ($this->package->type === 'MODULAR') {
            foreach ($this->package->sections as $index => $section) {
                $this->selections[$index] = $section->choice_type === 'SINGLE' ? '' : [];
            }
        }
    }

    public function getFixedItemsProperty()
    {
        return $this->package->items->whereNull('package_section_id');
    }

    public function getSectionsProperty()
    {
        return $this->package->sections->sortBy('sort_order');
    }

    public function getTotalPriceProperty(): float
    {
        if ($this->package->type === 'FIXED') {
            return (float) $this->package->price * $this->quantity;
        }

        $total = 0;
        foreach ($this->package->sections as $sIndex => $section) {
            $picked = $this->selections[$sIndex] ?? [];
            if (!is_array($picked)) {
                $picked = $picked ? [$picked] : [];
            }
            foreach ($picked as $itemId) {
                $item = $section->items->firstWhere('id', $itemId);
                if ($item) {
                    $total += $item->price;
                }
            }
        }

        return $total * $this->quantity;
    }

    public function nextStep(): void
    {
        if ($this->currentStep < $this->package->sections->count() - 1) {
            $this->currentStep++;
        }
    }

    public function prevStep(): void
    {
        if ($this->currentStep > 0) {
            $this->currentStep--;
        }
    }

    public function toggleSelection(int $sectionIndex, string $itemId): void
    {
        $section = $this->package->sections[$sectionIndex];

        if ($section->choice_type === 'SINGLE') {
            $this->selections[$sectionIndex] = $itemId;
        } else {
            $current = $this->selections[$sectionIndex] ?? [];
            if (in_array($itemId, $current)) {
                $current = array_values(array_filter($current, fn ($id) => $id !== $itemId));
            } elseif (count($current) < $section->max_pick) {
                $current[] = $itemId;
            }
            $this->selections[$sectionIndex] = $current;
        }
    }

    public function addToCart()
    {
        if ($this->package->type === 'MODULAR') {
            $this->validate();
        }

        $modifiers = [];
        $unitPrice = (float) $this->package->price;

        if ($this->package->type === 'FIXED') {
            foreach ($this->fixedItems as $item) {
                $modifiers[] = [
                    'id' => $item->id,
                    'name' => $item->product->name,
                    'price' => $item->price,
                    'type' => 'PACKAGE_ITEM',
                ];
            }
        } else {
            $unitPrice = 0;
            foreach ($this->package->sections as $sIndex => $section) {
                $picked = $this->selections[$sIndex] ?? [];
                if (!is_array($picked)) {
                    $picked = $picked ? [$picked] : [];
                }
                foreach ($picked as $itemId) {
                    $item = $section->items->firstWhere('id', $itemId);
                    if ($item) {
                        $modifiers[] = [
                            'id' => $item->id,
                            'name' => $section->name . ': ' . $item->product->name,
                            'price' => $item->price,
                            'type' => 'PACKAGE_SECTION',
                            'section_name' => $section->name,
                        ];
                        $unitPrice += $item->price;
                    }
                }
            }
        }

        $cartItem = [
            'id' => uniqid(),
            'product_id' => $this->package->id,
            'product_name' => $this->package->name,
            'variant' => null,
            'modifiers' => $modifiers,
            'quantity' => $this->quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $unitPrice * $this->quantity,
            'is_package' => true,
            'package_type' => $this->package->type,
        ];

        $cart = session('cart', []);
        $cart[] = $cartItem;
        session()->put('cart', $cart);

        return redirect()->route('customer.cart');
    }

    public function render()
    {
        $totalPrice = $this->totalPrice;

        return view('livewire.customer.package-detail', [
            'totalPrice' => $totalPrice,
        ])->layout('components.layouts.customer', ['showNav' => false]);
    }
}
