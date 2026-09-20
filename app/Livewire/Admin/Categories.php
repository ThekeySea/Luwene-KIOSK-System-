<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class Categories extends Component
{
    public bool $showModal = false;
    public ?string $editingId = null;
    public ?string $confirmingDelete = null;
    public ?string $confirmingPublish = null;

    public string $name = '';
    public string $description = '';
    public string $sort_order = '0';
    public bool $is_active = true;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'description', 'sort_order', 'confirmingDelete', 'confirmingPublish']);
        $this->sort_order = '0';
        $this->is_active = true;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $category = Category::findOrFail($id);

        $this->editingId = $category->id;
        $this->name = $category->name;
        $this->description = (string) $category->description;
        $this->sort_order = (string) $category->sort_order;
        $this->is_active = (bool) $category->is_active;
        $this->confirmingDelete = null;
        $this->confirmingPublish = null;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $slug = Str::slug($this->name);
        $taken = Category::where('slug', $slug);
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
            'sort_order' => $this->sort_order === '' ? 0 : (int) $this->sort_order,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            Category::findOrFail($this->editingId)->update($data);
        } else {
            Category::create($data);
        }

        $this->showModal = false;
        $this->dispatch('toast', message: 'Kategori disimpan.', type: 'success');
    }

    public function destroy(string $id): void
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            $this->dispatch('toast', message: 'Kategori masih punya produk, tidak bisa dihapus.', type: 'error');
            $this->confirmingDelete = null;
            return;
        }

        $category->delete();
        $this->confirmingDelete = null;
        $this->dispatch('toast', message: 'Kategori dihapus.', type: 'success');
    }

    public function publish(string $id): void
    {
        $category = Category::findOrFail($id);
        $category->update(['is_published' => true]);
        $this->confirmingPublish = null;
        $this->dispatch('toast', message: 'Kategori "'.$category->name.'" dipublish ke kiosk.', type: 'success');
    }

    public function unpublish(string $id): void
    {
        $category = Category::findOrFail($id);
        $category->update(['is_published' => false]);
        $this->dispatch('toast', message: 'Kategori "'.$category->name.'" dikembalikan ke draft.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.categories', [
            'categories' => Category::withCount('products')->orderBy('sort_order')->get(),
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Kategori',
        ]);
    }
}
