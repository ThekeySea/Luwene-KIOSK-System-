<?php

namespace App\Livewire\Admin;

use App\Models\Sambal;
use App\Models\SpiceLevel;
use Livewire\Component;

class Sambals extends Component
{
    public bool $showModal = false;
    public ?string $editingId = null;
    public ?string $confirmingDelete = null;

    public string $name = '';
    public string $description = '';
    public string $price = '0';
    public string $sort_order = '0';
    public bool $is_active = true;
    public bool $is_available = true;

    // Inline spice levels
    public array $spiceLevels = [];
    public string $newLevelName = '';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'spiceLevels.*.name' => 'required|string|max:50',
        ];
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'description', 'price', 'sort_order', 'confirmingDelete', 'spiceLevels', 'newLevelName']);
        $this->price = '0';
        $this->sort_order = '0';
        $this->is_active = true;
        $this->is_available = true;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $sambal = Sambal::with('spiceLevels')->findOrFail($id);

        $this->editingId = $sambal->id;
        $this->name = $sambal->name;
        $this->description = (string) $sambal->description;
        $this->price = (string) $sambal->price;
        $this->sort_order = (string) $sambal->sort_order;
        $this->is_active = (bool) $sambal->is_active;
        $this->is_available = (bool) $sambal->is_available;
        $this->spiceLevels = $sambal->spiceLevels->map(fn ($l) => ['id' => $l->id, 'name' => $l->name, 'level' => $l->level, 'sort_order' => $l->sort_order])->toArray();
        $this->newLevelName = '';
        $this->confirmingDelete = null;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function addLevel(): void
    {
        $name = trim($this->newLevelName);
        if ($name === '') {
            return;
        }

        $maxLevel = collect($this->spiceLevels)->max('level') ?? -1;

        $this->spiceLevels[] = [
            'id' => null,
            'name' => $name,
            'level' => $maxLevel + 1,
            'sort_order' => count($this->spiceLevels),
        ];

        $this->newLevelName = '';
    }

    public function removeLevel(int $index): void
    {
        unset($this->spiceLevels[$index]);
        $this->spiceLevels = array_values($this->spiceLevels);
        // Re-index levels
        foreach ($this->spiceLevels as $i => &$level) {
            $level['level'] = $i;
            $level['sort_order'] = $i;
        }
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => trim($this->name),
            'description' => trim($this->description) ?: null,
            'price' => (float) $this->price,
            'sort_order' => $this->sort_order === '' ? 0 : (int) $this->sort_order,
            'is_active' => $this->is_active,
            'is_available' => $this->is_available,
        ];

        if ($this->editingId) {
            $sambal = Sambal::findOrFail($this->editingId);
            $sambal->update($data);
        } else {
            $sambal = Sambal::create($data);
        }

        // Sync spice levels
        $existingIds = collect($this->spiceLevels)->pluck('id')->filter()->toArray();
        $sambal->spiceLevels()->whereNotIn('id', $existingIds)->delete();

        foreach ($this->spiceLevels as $i => $level) {
            if ($level['id']) {
                SpiceLevel::where('id', $level['id'])->update([
                    'name' => $level['name'],
                    'level' => $i,
                    'sort_order' => $i,
                ]);
            } else {
                $sambal->spiceLevels()->create([
                    'name' => $level['name'],
                    'level' => $i,
                    'sort_order' => $i,
                ]);
            }
        }

        $this->showModal = false;
        $this->dispatch('toast', message: 'Sambal disimpan.', type: 'success');
    }

    public function destroy(string $id): void
    {
        $sambal = Sambal::withCount('products')->findOrFail($id);

        if ($sambal->products_count > 0) {
            $this->dispatch('toast', message: 'Sambal masih digunakan di produk, tidak bisa dihapus.', type: 'error');
            $this->confirmingDelete = null;
            return;
        }

        $sambal->delete();
        $this->confirmingDelete = null;
        $this->dispatch('toast', message: 'Sambal dihapus.', type: 'success');
    }

    public function toggleActive(string $id): void
    {
        $sambal = Sambal::findOrFail($id);
        $sambal->update(['is_active' => !$sambal->is_active]);
    }

    public function render()
    {
        return view('livewire.admin.sambals', [
            'sambals' => Sambal::withCount('spiceLevels', 'products')->orderBy('sort_order')->get(),
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Sambal',
        ]);
    }
}
