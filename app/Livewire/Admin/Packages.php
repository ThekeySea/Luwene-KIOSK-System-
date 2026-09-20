<?php

namespace App\Livewire\Admin;

use App\Models\Package;
use App\Models\PackageItem;
use App\Models\PackageSection;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Packages extends Component
{
    use WithFileUploads;

    public string $search = '';

    public bool $showModal = false;
    public ?string $editingId = null;
    public ?string $confirmingDelete = null;
    public ?string $confirmingPublish = null;

    public string $name = '';
    public string $code = '';
    public string $description = '';
    public string $price = '';
    public string $type = 'FIXED';
    public bool $is_active = true;
    public bool $is_published = false;
    public bool $is_published_delivery = false;
    public $photo = null;

    // Fixed items
    public array $fixedItems = [];
    // ['product_id' => '', 'quantity' => 1, 'role' => 'FIXED', 'price_override' => '']

    // Modular sections
    public array $sections = [];
    // ['name' => '', 'choice_type' => 'SINGLE', 'max_pick' => 1, 'items' => [
    //     ['product_id' => '', 'price_override' => '', 'sort_order' => 0]
    // ]]

    protected function rules(): array
    {
        $uniqueCode = $this->editingId
            ? 'unique:packages,code,' . $this->editingId
            : 'unique:packages,code';

        $isFixed = $this->type === 'FIXED';

        return [
            'name' => 'required|string|max:150',
            'code' => ['required', 'string', 'max:50', $uniqueCode],
            'description' => 'nullable|string',
            'price' => 'required_if:type,FIXED|nullable|numeric|min:0',
            'type' => 'required|in:FIXED,MODULAR',
            'photo' => 'nullable|image|max:2048',
            'fixedItems' => $isFixed ? 'required|array|min:1' : 'nullable|array',
            'fixedItems.*.product_id' => $isFixed ? 'required|exists:products,id' : 'nullable',
            'fixedItems.*.quantity' => $isFixed ? 'required|integer|min:1' : 'nullable',
            'fixedItems.*.role' => $isFixed ? 'required|in:FIXED,CHOICE' : 'nullable',
            'fixedItems.*.price_override' => $isFixed ? 'nullable|numeric|min:0' : 'nullable',
            'sections' => $isFixed ? 'nullable|array' : 'required|array|min:1',
            'sections.*.name' => $isFixed ? 'nullable|string|max:100' : 'required|string|max:100',
            'sections.*.choice_type' => $isFixed ? 'nullable|in:SINGLE,MULTIPLE' : 'required|in:SINGLE,MULTIPLE',
            'sections.*.max_pick' => $isFixed ? 'nullable|integer|min:1' : 'required|integer|min:1',
            'sections.*.items' => $isFixed ? 'nullable|array' : 'required|array|min:1',
            'sections.*.items.*.product_id' => $isFixed ? 'nullable' : 'required|exists:products,id',
            'sections.*.items.*.price_override' => 'nullable|numeric|min:0',
        ];
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'code', 'description', 'price', 'type', 'photo', 'confirmingDelete', 'confirmingPublish', 'fixedItems', 'sections']);
        $this->type = 'FIXED';
        $this->price = '';
        $this->is_active = true;
        $this->is_published = false;
        $this->is_published_delivery = false;
        $this->fixedItems = [['product_id' => '', 'quantity' => 1, 'role' => 'FIXED', 'price_override' => '']];
        $this->sections = [];
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $pkg = Package::with(['items.product', 'sections.items.product'])->findOrFail($id);

        $this->editingId = $pkg->id;
        $this->name = $pkg->name;
        $this->code = $pkg->code;
        $this->description = (string) $pkg->description;
        $this->price = (string) $pkg->price;
        $this->type = $pkg->type;
        $this->is_active = $pkg->is_active;
        $this->is_published = $pkg->is_published;
        $this->is_published_delivery = $pkg->is_published_delivery;
        $this->photo = null;

        // Load fixed items (items without section)
        $this->fixedItems = $pkg->items->whereNull('package_section_id')->map(fn ($item) => [
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'role' => $item->role,
            'price_override' => $item->price_override !== null ? (string) $item->price_override : '',
        ])->toArray();

        if (empty($this->fixedItems)) {
            $this->fixedItems = [['product_id' => '', 'quantity' => 1, 'role' => 'FIXED', 'price_override' => '']];
        }

        // Load sections
        $this->sections = $pkg->sections->map(fn ($section) => [
            'id' => $section->id,
            'name' => $section->name,
            'choice_type' => $section->choice_type,
            'max_pick' => $section->max_pick,
            'items' => $section->items->map(fn ($item) => [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'price_override' => $item->price_override !== null ? (string) $item->price_override : '',
                'sort_order' => $item->sort_order,
            ])->toArray(),
        ])->toArray();

        $this->confirmingDelete = null;
        $this->confirmingPublish = null;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    // Fixed items management
    public function addFixedItem(): void
    {
        $this->fixedItems[] = ['product_id' => '', 'quantity' => 1, 'role' => 'FIXED', 'price_override' => ''];
    }

    public function removeFixedItem(int $index): void
    {
        unset($this->fixedItems[$index]);
        $this->fixedItems = array_values($this->fixedItems);
    }

    public function updateFixedItem(int $index, string $field, mixed $value): void
    {
        if (!isset($this->fixedItems[$index])) return;
        $this->fixedItems[$index][$field] = $value;
    }

    // Sections management
    public function addSection(): void
    {
        $this->sections[] = [
            'name' => '',
            'choice_type' => 'SINGLE',
            'max_pick' => 1,
            'items' => [['product_id' => '', 'price_override' => '', 'sort_order' => 0]],
        ];
    }

    public function removeSection(int $sectionIndex): void
    {
        unset($this->sections[$sectionIndex]);
        $this->sections = array_values($this->sections);
    }

    public function updateSection(int $sectionIndex, string $field, mixed $value): void
    {
        if (!isset($this->sections[$sectionIndex])) return;
        $this->sections[$sectionIndex][$field] = $value;
    }

    public function addSectionItem(int $sectionIndex): void
    {
        $this->sections[$sectionIndex]['items'][] = [
            'product_id' => '',
            'price_override' => '',
            'sort_order' => count($this->sections[$sectionIndex]['items']),
        ];
    }

    public function removeSectionItem(int $sectionIndex, int $itemIndex): void
    {
        unset($this->sections[$sectionIndex]['items'][$itemIndex]);
        $this->sections[$sectionIndex]['items'] = array_values($this->sections[$sectionIndex]['items']);
    }

    public function updateSectionItem(int $sectionIndex, int $itemIndex, string $field, mixed $value): void
    {
        if (!isset($this->sections[$sectionIndex]['items'][$itemIndex])) return;
        $this->sections[$sectionIndex]['items'][$itemIndex][$field] = $value;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => trim($this->name),
            'code' => trim($this->code),
            'description' => trim($this->description) ?: null,
            'price' => $this->type === 'FIXED' ? (float) $this->price : 0,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'is_published' => $this->is_published,
            'is_published_delivery' => $this->is_published_delivery,
        ];

        try {
            if ($this->editingId) {
                $pkg = Package::findOrFail($this->editingId);
                if ($this->photo) {
                    if ($pkg->image) {
                        Storage::disk('public')->delete($pkg->image);
                    }
                    $data['image'] = $this->photo->store('packages', 'public');
                }
                $pkg->update($data);
            } else {
                if ($this->photo) {
                    $data['image'] = $this->photo->store('packages', 'public');
                }
                $pkg = Package::create($data);
            }

            if ($this->type === 'FIXED') {
                $this->syncFixedItems($pkg);
            } else {
                $this->syncModularSections($pkg);
            }
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Gagal menyimpan: ' . $e->getMessage(), type: 'error');
            return;
        }

        $this->showModal = false;
        $this->dispatch('toast', message: 'Paket disimpan.', type: 'success');
    }

    private function syncFixedItems(Package $pkg): void
    {
        // Delete sections (modular) if switching type
        $pkg->sections()->delete();

        // Remove section items
        $pkg->items()->whereNotNull('package_section_id')->delete();

        // Sync fixed items
        $existingIds = [];
        foreach ($this->fixedItems as $index => $item) {
            if (empty($item['product_id'])) continue;

            $pivotData = [
                'quantity' => (int) $item['quantity'],
                'role' => $item['role'],
                'price_override' => $item['price_override'] !== '' ? (float) $item['price_override'] : null,
                'is_required' => true,
                'sort_order' => $index,
            ];

            if (!empty($item['id'])) {
                PackageItem::where('id', $item['id'])->update($pivotData);
                $existingIds[] = $item['id'];
            } else {
                $newItem = $pkg->items()->create(array_merge($pivotData, [
                    'product_id' => $item['product_id'],
                ]));
                $existingIds[] = $newItem->id;
            }
        }

        $pkg->items()->whereNull('package_section_id')->whereNotIn('id', $existingIds)->delete();
    }

    private function syncModularSections(Package $pkg): void
    {
        // Delete non-section items (fixed)
        $pkg->items()->whereNull('package_section_id')->delete();

        $existingSectionIds = [];
        foreach ($this->sections as $sIndex => $sectionData) {
            if (empty($sectionData['name'])) continue;

            $sectionPayload = [
                'name' => $sectionData['name'],
                'choice_type' => $sectionData['choice_type'],
                'max_pick' => (int) $sectionData['max_pick'],
                'sort_order' => $sIndex,
            ];

            if (!empty($sectionData['id'])) {
                PackageSection::where('id', $sectionData['id'])->update($sectionPayload);
                $sectionId = $sectionData['id'];
            } else {
                $newSection = $pkg->sections()->create($sectionPayload);
                $sectionId = $newSection->id;
            }
            $existingSectionIds[] = $sectionId;

            // Sync items in this section
            $existingItemIds = [];
            foreach ($sectionData['items'] as $iIndex => $itemData) {
                if (empty($itemData['product_id'])) continue;

                $itemPayload = [
                    'package_section_id' => $sectionId,
                    'product_id' => $itemData['product_id'],
                    'quantity' => 1,
                    'role' => 'CHOICE',
                    'price_override' => $itemData['price_override'] !== '' ? (float) $itemData['price_override'] : null,
                    'is_required' => false,
                    'sort_order' => $iIndex,
                ];

                if (!empty($itemData['id'])) {
                    PackageItem::where('id', $itemData['id'])->update($itemPayload);
                    $existingItemIds[] = $itemData['id'];
                } else {
                    $newItem = $pkg->items()->create($itemPayload);
                    $existingItemIds[] = $newItem->id;
                }
            }

            $pkg->items()->where('package_section_id', $sectionId)->whereNotIn('id', $existingItemIds)->delete();
        }

        $pkg->sections()->whereNotIn('id', $existingSectionIds)->delete();
    }

    public function toggleActive(string $id): void
    {
        $pkg = Package::findOrFail($id);
        $pkg->update(['is_active' => !$pkg->is_active]);
    }

    public function publish(string $id): void
    {
        $pkg = Package::findOrFail($id);
        $pkg->update(['is_published' => true]);
        $this->confirmingPublish = null;
        $this->dispatch('toast', message: "{$pkg->name} dipublish ke kiosk.", type: 'success');
    }

    public function unpublish(string $id): void
    {
        $pkg = Package::findOrFail($id);
        $pkg->update(['is_published' => false]);
        $this->dispatch('toast', message: "{$pkg->name} dikembalikan ke draft.", type: 'success');
    }

    public function destroy(string $id): void
    {
        Package::findOrFail($id)->delete();
        $this->confirmingDelete = null;
        $this->dispatch('toast', message: 'Paket diarsipkan.', type: 'success');
    }

    public function render()
    {
        $packages = Package::withCount('items')
            ->when($this->search !== '', fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.admin.packages', [
            'packages' => $packages,
            'allProducts' => Product::where('is_active', true)->orderBy('name')->get(),
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Paket',
        ]);
    }
}
