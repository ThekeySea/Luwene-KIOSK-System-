<?php

namespace App\Livewire\Admin;

use App\Models\Promo;
use Illuminate\Support\Str;
use Livewire\Component;

class Promos extends Component
{
    public bool $showModal = false;
    public ?string $editingId = null;
    public ?string $confirmingDelete = null;

    public string $code = '';
    public string $name = '';
    public string $type = 'FIXED';
    public string $value = '';
    public string $min_order_amount = '0';
    public string $max_discount_amount = '';
    public bool $is_active = true;
    public string $starts_at = '';
    public string $ends_at = '';
    public string $usage_limit = '';

    protected function rules(): array
    {
        return [
            'code' => 'required|string|max:30',
            'name' => 'required|string|max:150',
            'type' => 'required|in:PERCENT,FIXED',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'usage_limit' => 'nullable|integer|min:1',
        ];
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'code', 'name', 'value', 'min_order_amount', 'max_discount_amount', 'starts_at', 'ends_at', 'usage_limit', 'confirmingDelete']);
        $this->type = 'FIXED';
        $this->min_order_amount = '0';
        $this->is_active = true;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $promo = Promo::findOrFail($id);

        $this->editingId = $promo->id;
        $this->code = $promo->code;
        $this->name = $promo->name;
        $this->type = $promo->type;
        $this->value = (string) $promo->value;
        $this->min_order_amount = (string) $promo->min_order_amount;
        $this->max_discount_amount = $promo->max_discount_amount !== null ? (string) $promo->max_discount_amount : '';
        $this->is_active = (bool) $promo->is_active;
        $this->starts_at = $promo->starts_at ? $promo->starts_at->format('Y-m-d') : '';
        $this->ends_at = $promo->ends_at ? $promo->ends_at->format('Y-m-d') : '';
        $this->usage_limit = $promo->usage_limit !== null ? (string) $promo->usage_limit : '';
        $this->confirmingDelete = null;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $code = Str::upper(trim($this->code));
        $taken = Promo::where('code', $code);
        if ($this->editingId) {
            $taken->where('id', '!=', $this->editingId);
        }
        if ($taken->exists()) {
            $this->addError('code', 'Kode sudah dipakai.');
            return;
        }

        $data = [
            'code' => $code,
            'name' => trim($this->name),
            'type' => $this->type,
            'value' => $this->value,
            'min_order_amount' => $this->min_order_amount === '' ? 0 : $this->min_order_amount,
            'max_discount_amount' => $this->max_discount_amount === '' ? null : $this->max_discount_amount,
            'is_active' => $this->is_active,
            'starts_at' => $this->starts_at === '' ? null : $this->starts_at,
            'ends_at' => $this->ends_at === '' ? null : $this->ends_at,
            'usage_limit' => $this->usage_limit === '' ? null : (int) $this->usage_limit,
        ];

        if ($this->editingId) {
            Promo::findOrFail($this->editingId)->update($data);
        } else {
            Promo::create($data);
        }

        $this->showModal = false;
        $this->dispatch('toast', message: 'Promo disimpan.', type: 'success');
    }

    public function toggleActive(string $id): void
    {
        $promo = Promo::findOrFail($id);
        $promo->update(['is_active' => ! $promo->is_active]);
        $this->dispatch('toast', message: "Promo {$promo->code} ".($promo->is_active ? 'diaktifkan.' : 'dinonaktifkan.'), type: 'success');
    }

    public function destroy(string $id): void
    {
        Promo::findOrFail($id)->delete();
        $this->confirmingDelete = null;
        $this->dispatch('toast', message: 'Promo dihapus.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.promos', [
            'promos' => Promo::orderBy('created_at', 'desc')->get(),
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Promo',
        ]);
    }
}
