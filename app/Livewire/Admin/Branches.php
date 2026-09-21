<?php

namespace App\Livewire\Admin;

use App\Models\Branch;
use Livewire\Component;

class Branches extends Component
{
    public ?string $editingId = null;
    public string $name = '';
    public string $address = '';
    public string $latitude = '';
    public string $longitude = '';
    public string $delivery_fee = '5000';
    public string $estimated_delivery_minutes = '30';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'delivery_fee' => 'required|numeric|min:0',
            'estimated_delivery_minutes' => 'required|integer|min:5|max:120',
        ];
    }

    public function mount(): void
    {
        $branch = Branch::first();
        if ($branch) {
            $this->editingId = $branch->id;
            $this->name = $branch->name;
            $this->address = $branch->address ?? '';
            $this->latitude = $branch->latitude ? (string) $branch->latitude : '';
            $this->longitude = $branch->longitude ? (string) $branch->longitude : '';
            $this->delivery_fee = (string) ($branch->delivery_fee ?? 5000);
            $this->estimated_delivery_minutes = (string) ($branch->estimated_delivery_minutes ?? 30);
        }
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => trim($this->name),
            'address' => trim($this->address) ?: null,
            'latitude' => $this->latitude !== '' ? (float) $this->latitude : null,
            'longitude' => $this->longitude !== '' ? (float) $this->longitude : null,
            'delivery_fee' => (float) $this->delivery_fee,
            'estimated_delivery_minutes' => (int) $this->estimated_delivery_minutes,
        ];

        if ($this->editingId) {
            Branch::findOrFail($this->editingId)->update($data);
        } else {
            $data['status'] = 'ACTIVE';
            Branch::create($data);
            $this->editingId = Branch::first()?->id;
        }

        $this->dispatch('toast', message: 'Info restoran disimpan.', type: 'success');
    }

    public function render()
    {
        $branch = Branch::first();
        $tableCount = $branch ? $branch->tables()->count() : 0;
        $staffCount = $branch ? \App\Models\User::where('role', '!=', 'CUSTOMER')->count() : 0;
        $orderCount = $branch ? $branch->orders()->count() : 0;

        return view('livewire.admin.branches', [
            'branch' => $branch,
            'tableCount' => $tableCount,
            'staffCount' => $staffCount,
            'orderCount' => $orderCount,
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Info Restoran',
        ]);
    }
}
