<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sambal;
use App\Models\ModifierGroup;
use App\Models\ProductModifierGroup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithFileUploads;

    public string $search = '';
    public string $categoryFilter = '';

    public bool $showModal = false;
    public ?string $editingId = null;
    public ?string $confirmingDelete = null;
    public ?string $confirmingPublish = null;

    public string $name = '';
    public string $description = '';
    public string $category_id = '';
    public string $base_price = '';
    public string $sort_order = '0';
    public bool $is_active = true;
    public bool $is_available = true;
    public bool $is_featured = false;
    public $photo = null;

    // Modifier assignments
    public array $selectedSambals = [];
    public array $sambalPrices = [];
    public bool $sambalIsRequired = true;
    public array $selectedNasi = [];
    public bool $nasiIsRequired = true;
    public array $selectedExtras = [];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|max:2048',
        ];
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'description', 'category_id', 'base_price', 'sort_order', 'photo', 'confirmingDelete', 'confirmingPublish', 'selectedSambals', 'sambalPrices', 'sambalIsRequired', 'selectedNasi', 'nasiIsRequired', 'selectedExtras']);
        $this->sort_order = '0';
        $this->is_active = true;
        $this->is_available = true;
        $this->is_featured = false;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $product = Product::with([
            'sambals',
            'modifierGroups' => fn ($q) => $q->withPivot('id as pivot_id'),
        ])->findOrFail($id);

        $this->editingId = $product->id;
        $this->name = $product->name;
        $this->description = (string) $product->description;
        $this->category_id = $product->category_id;
        $this->base_price = (string) $product->base_price;
        $this->sort_order = (string) $product->sort_order;
        $this->is_active = (bool) $product->is_active;
        $this->is_available = (bool) $product->is_available;
        $this->is_featured = (bool) $product->is_featured;
        $this->photo = null;

        // Load assignments
        $this->selectedSambals = $product->sambals->pluck('id')->toArray();
        $this->sambalPrices = $product->sambals->pluck('pivot.price', 'id')->map(fn ($p) => (string) $p)->toArray();
        $this->sambalIsRequired = $product->sambals->contains('pivot.is_required', true);

        $nasiGroup = $product->modifierGroups->firstWhere('type', 'NASI');
        $extraGroup = $product->modifierGroups->firstWhere('type', 'EXTRA');
        $this->selectedNasi = $nasiGroup ? $nasiGroup->modifiers->pluck('id')->toArray() : [];
        $this->nasiIsRequired = $nasiGroup ? (bool) $nasiGroup->pivot->is_required : true;
        $this->selectedExtras = $extraGroup ? $extraGroup->modifiers->pluck('id')->toArray() : [];

        $this->confirmingDelete = null;
        $this->confirmingPublish = null;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $slug = Str::slug($this->name);
        $taken = Product::withTrashed()->where('slug', $slug);
        if ($this->editingId) {
            $taken->where('id', '!=', $this->editingId);
        }
        if ($taken->exists()) {
            $slug .= '-'.Str::lower(Str::random(4));
        }

        $data = [
            'name' => trim($this->name),
            'slug' => $slug,
            'description' => trim($this->description) ?: null,
            'category_id' => $this->category_id,
            'base_price' => $this->base_price,
            'sort_order' => $this->sort_order === '' ? 0 : (int) $this->sort_order,
            'is_active' => $this->is_active,
            'is_available' => $this->is_available,
            'is_featured' => $this->is_featured,
        ];

        if ($this->editingId) {
            $product = Product::findOrFail($this->editingId);

            if ($this->photo) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $this->photo->store('products', 'public');
            }

            $product->update($data);
        } else {
            if ($this->photo) {
                $data['image'] = $this->photo->store('products', 'public');
            }

            $product = Product::create($data);
        }

        // Sync sambals with pivot prices & is_required
        $syncData = [];
        foreach ($this->selectedSambals as $sambalId) {
            $syncData[$sambalId] = [
                'price' => (float) ($this->sambalPrices[$sambalId] ?? 0),
                'is_required' => $this->sambalIsRequired,
                'sort_order' => array_search($sambalId, $this->selectedSambals),
            ];
        }
        $product->sambals()->sync($syncData);

        // Sync nasi modifier group
        $this->syncModifierGroup($product, 'NASI', $this->selectedNasi, $this->nasiIsRequired);

        // Sync extra modifier group
        $this->syncModifierGroup($product, 'EXTRA', $this->selectedExtras, false);

        $this->showModal = false;
        $this->dispatch('toast', message: 'Produk disimpan.', type: 'success');
    }

    private function syncModifierGroup(Product $product, string $type, array $selectedModifierIds, bool $isRequired): void
    {
        $group = ModifierGroup::where('type', $type)->first();

        if (!$group) {
            return;
        }

        $pivot = ProductModifierGroup::where('product_id', $product->id)
            ->where('modifier_group_id', $group->id)
            ->first();

        if ($isSelected = count($selectedModifierIds) > 0) {
            if ($pivot) {
                $pivot->update([
                    'is_required' => $isRequired,
                    'min_selection' => $isRequired ? 1 : 0,
                    'max_selection' => $isRequired ? 1 : null,
                ]);
            } else {
                ProductModifierGroup::create([
                    'product_id' => $product->id,
                    'modifier_group_id' => $group->id,
                    'is_required' => $isRequired,
                    'min_selection' => $isRequired ? 1 : 0,
                    'max_selection' => $isRequired ? 1 : null,
                    'sort_order' => $type === 'NASI' ? 1 : 2,
                ]);
            }
        } else {
            if ($pivot) {
                $pivot->delete();
            }
        }
    }

    public function toggleAvailable(string $id): void
    {
        $product = Product::findOrFail($id);
        $product->update(['is_available' => ! $product->is_available]);
        $this->dispatch('toast', message: $product->is_available ? "{$product->name} tersedia." : "{$product->name} ditandai habis.", type: 'success');
    }

    public function destroy(string $id): void
    {
        Product::findOrFail($id)->delete();
        $this->confirmingDelete = null;
        $this->dispatch('toast', message: 'Produk diarsipkan.', type: 'success');
    }

    public function publish(string $id): void
    {
        $product = Product::findOrFail($id);
        $product->update(['is_published' => true]);
        $this->confirmingPublish = null;
        $this->dispatch('toast', message: "{$product->name} dipublish ke kiosk.", type: 'success');
    }

    public function unpublish(string $id): void
    {
        $product = Product::findOrFail($id);
        $product->update(['is_published' => false]);
        $this->dispatch('toast', message: "{$product->name} dikembalikan ke draft.", type: 'success');
    }

    public function render()
    {
        $products = Product::with('category')
            ->when($this->search !== '', fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->categoryFilter !== '', fn ($q) => $q->where('category_id', $this->categoryFilter))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('livewire.admin.products', [
            'products' => $products,
            'categories' => Category::orderBy('sort_order')->get(),
            'allSambals' => Sambal::where('is_active', true)->orderBy('sort_order')->get(),
            'nasiModifiers' => ModifierGroup::where('type', 'NASI')->first()?->modifiers()->where('is_active', true)->orderBy('sort_order')->get() ?? collect(),
            'extraModifiers' => ModifierGroup::where('type', 'EXTRA')->first()?->modifiers()->where('is_active', true)->orderBy('sort_order')->get() ?? collect(),
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Produk',
        ]);
    }
}
