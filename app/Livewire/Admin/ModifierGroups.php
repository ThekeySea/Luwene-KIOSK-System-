<?php

namespace App\Livewire\Admin;

use App\Models\ModifierGroup;
use App\Models\Modifier;
use Livewire\Component;

class ModifierGroups extends Component
{
    public bool $showModal = false;
    public ?string $editingId = null;
    public ?string $confirmingDelete = null;

    public string $name = '';
    public string $description = '';
    public string $type = 'EXTRA';
    public bool $is_required = false;
    public string $min_selection = '0';
    public string $max_selection = '';
    public string $sort_order = '0';

    // Inline modifiers
    public array $modifiers = [];
    public string $newModifierName = '';
    public string $newModifierPrice = '0';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'type' => 'required|in:NASI,EXTRA',
            'min_selection' => 'nullable|integer|min:0',
            'max_selection' => 'nullable|integer|min:0',
            'modifiers.*.name' => 'required|string|max:50',
            'modifiers.*.price' => 'required|numeric|min:0',
        ];
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'description', 'type', 'is_required', 'min_selection', 'max_selection', 'sort_order', 'confirmingDelete', 'modifiers', 'newModifierName', 'newModifierPrice']);
        $this->type = 'EXTRA';
        $this->sort_order = '0';
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $group = ModifierGroup::with('modifiers')->findOrFail($id);

        $this->editingId = $group->id;
        $this->name = $group->name;
        $this->description = (string) $group->description;
        $this->type = $group->type;
        $this->is_required = (bool) $group->is_required;
        $this->min_selection = (string) $group->min_selection;
        $this->max_selection = $group->max_selection !== null ? (string) $group->max_selection : '';
        $this->sort_order = (string) $group->sort_order;
        $this->modifiers = $group->modifiers->map(fn ($m) => ['id' => $m->id, 'name' => $m->name, 'price' => (string) $m->price, 'sort_order' => $m->sort_order])->toArray();
        $this->newModifierName = '';
        $this->newModifierPrice = '0';
        $this->confirmingDelete = null;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function addModifier(): void
    {
        $name = trim($this->newModifierName);
        if ($name === '') {
            return;
        }

        $this->modifiers[] = [
            'id' => null,
            'name' => $name,
            'price' => $this->newModifierPrice,
            'sort_order' => count($this->modifiers),
        ];

        $this->newModifierName = '';
        $this->newModifierPrice = '0';
    }

    public function removeModifier(int $index): void
    {
        unset($this->modifiers[$index]);
        $this->modifiers = array_values($this->modifiers);
        foreach ($this->modifiers as $i => &$mod) {
            $mod['sort_order'] = $i;
        }
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => trim($this->name),
            'description' => trim($this->description) ?: null,
            'type' => $this->type,
            'is_required' => $this->is_required,
            'min_selection' => $this->min_selection === '' ? 0 : (int) $this->min_selection,
            'max_selection' => $this->max_selection !== '' ? (int) $this->max_selection : null,
            'sort_order' => $this->sort_order === '' ? 0 : (int) $this->sort_order,
        ];

        if ($this->editingId) {
            $group = ModifierGroup::findOrFail($this->editingId);
            $group->update($data);
        } else {
            $group = ModifierGroup::create($data);
        }

        // Sync modifiers
        $existingIds = collect($this->modifiers)->pluck('id')->filter()->toArray();
        $group->modifiers()->whereNotIn('id', $existingIds)->delete();

        foreach ($this->modifiers as $i => $mod) {
            if ($mod['id']) {
                Modifier::where('id', $mod['id'])->update([
                    'name' => $mod['name'],
                    'price' => (float) $mod['price'],
                    'sort_order' => $i,
                ]);
            } else {
                $group->modifiers()->create([
                    'name' => $mod['name'],
                    'price' => (float) $mod['price'],
                    'sort_order' => $i,
                ]);
            }
        }

        $this->showModal = false;
        $this->dispatch('toast', message: 'Grup modifier disimpan.', type: 'success');
    }

    public function destroy(string $id): void
    {
        $group = ModifierGroup::withCount('products')->findOrFail($id);

        if ($group->products_count > 0) {
            $this->dispatch('toast', message: 'Grup masih digunakan di produk, tidak bisa dihapus.', type: 'error');
            $this->confirmingDelete = null;
            return;
        }

        $group->delete();
        $this->confirmingDelete = null;
        $this->dispatch('toast', message: 'Grup modifier dihapus.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.modifier-groups', [
            'groups' => ModifierGroup::withCount('modifiers', 'products')->orderBy('sort_order')->get(),
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Tambahan',
        ]);
    }
}
