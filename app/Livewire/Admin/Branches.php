<?php

namespace App\Livewire\Admin;

use App\Models\Branch;
use App\Models\RestaurantTable;
use Livewire\Component;

class Branches extends Component
{
    public bool $showModal = false;
    public ?string $editingId = null;
    public ?string $confirmingDelete = null;

    public string $name = '';
    public string $address = '';
    public string $status = 'ACTIVE';
    public string $latitude = '';
    public string $longitude = '';
    public string $delivery_fee = '0';
    public string $estimated_delivery_minutes = '30';

    public bool $showTableModal = false;
    public ?string $editingTableId = null;
    public string $selectedBranchId = '';
    public string $tableNumber = '';
    public string $tableCapacity = '4';
    public string $tableStatus = 'AVAILABLE';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'address' => 'nullable|string|max:255',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'delivery_fee' => 'required|numeric|min:0',
            'estimated_delivery_minutes' => 'required|integer|min:5|max:120',
        ];
    }

    public function tableRules(): array
    {
        return [
            'tableNumber' => 'required|integer|min:1',
            'tableCapacity' => 'required|integer|min:1|max:50',
            'tableStatus' => 'required|in:AVAILABLE,OCCUPIED,RESERVED',
        ];
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'address', 'confirmingDelete']);
        $this->status = 'ACTIVE';
        $this->latitude = '';
        $this->longitude = '';
        $this->delivery_fee = '0';
        $this->estimated_delivery_minutes = '30';
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $branch = Branch::findOrFail($id);
        $this->editingId = $branch->id;
        $this->name = $branch->name;
        $this->address = $branch->address ?? '';
        $this->status = $branch->status ?? 'ACTIVE';
        $this->latitude = $branch->latitude ? (string) $branch->latitude : '';
        $this->longitude = $branch->longitude ? (string) $branch->longitude : '';
        $this->delivery_fee = (string) ($branch->delivery_fee ?? 0);
        $this->estimated_delivery_minutes = (string) ($branch->estimated_delivery_minutes ?? 30);
        $this->confirmingDelete = null;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => trim($this->name),
            'address' => trim($this->address) ?: null,
            'status' => $this->status,
            'latitude' => $this->latitude !== '' ? (float) $this->latitude : null,
            'longitude' => $this->longitude !== '' ? (float) $this->longitude : null,
            'delivery_fee' => (float) $this->delivery_fee,
            'estimated_delivery_minutes' => (int) $this->estimated_delivery_minutes,
        ];

        if ($this->editingId) {
            Branch::findOrFail($this->editingId)->update($data);
        } else {
            Branch::create($data);
        }

        $this->showModal = false;
        $this->dispatch('toast', message: 'Data cabang disimpan.', type: 'success');
    }

    public function toggleStatus(string $id): void
    {
        $branch = Branch::findOrFail($id);
        $branch->update(['status' => ($branch->status ?? 'ACTIVE') === 'ACTIVE' ? 'INACTIVE' : 'ACTIVE']);
        $this->dispatch('toast', message: "Cabang {$branch->name} ".(($branch->status ?? 'ACTIVE') === 'ACTIVE' ? 'diaktifkan.' : 'dinonaktifkan.'), type: 'success');
    }

    public function destroy(string $id): void
    {
        $branch = Branch::withCount(['users', 'orders'])->findOrFail($id);

        if ($branch->users_count > 0 || $branch->orders_count > 0) {
            $this->dispatch('toast', message: 'Cabang masih punya staff atau riwayat order, tidak bisa dihapus.', type: 'error');
            $this->confirmingDelete = null;
            return;
        }

        $branch->tables()->delete();
        $branch->delete();
        $this->confirmingDelete = null;
        $this->dispatch('toast', message: 'Cabang dihapus.', type: 'success');
    }

    public function openTables(string $branchId): void
    {
        $this->selectedBranchId = $branchId;
        $this->showTableModal = true;
    }

    public function openCreateTable(): void
    {
        $this->reset(['editingTableId', 'tableNumber', 'tableCapacity', 'tableStatus']);
        $this->tableCapacity = '4';
        $this->tableStatus = 'AVAILABLE';
        $this->resetErrorBag('tableNumber', 'tableCapacity', 'tableStatus');
        $this->editingTableId = '__new__';
    }

    public function openEditTable(string $tableId): void
    {
        $table = RestaurantTable::findOrFail($tableId);
        $this->editingTableId = $table->id;
        $this->tableNumber = (string) $table->table_number;
        $this->tableCapacity = (string) $table->capacity;
        $this->tableStatus = $table->status ?? 'AVAILABLE';
        $this->resetErrorBag('tableNumber', 'tableCapacity', 'tableStatus');
    }

    public function saveTable(): void
    {
        $this->validate($this->tableRules());

        $data = [
            'branch_id' => $this->selectedBranchId,
            'table_number' => (int) $this->tableNumber,
            'capacity' => (int) $this->tableCapacity,
            'status' => $this->tableStatus,
        ];

        $duplicate = RestaurantTable::where('branch_id', $this->selectedBranchId)
            ->where('table_number', $data['table_number']);

        if ($this->editingTableId && $this->editingTableId !== '__new__') {
            $duplicate->where('id', '!=', $this->editingTableId);
        }

        if ($duplicate->exists()) {
            $this->addError('tableNumber', 'Nomor meja sudah ada di cabang ini.');
            return;
        }

        if ($this->editingTableId && $this->editingTableId !== '__new__') {
            RestaurantTable::findOrFail($this->editingTableId)->update($data);
        } else {
            RestaurantTable::create($data);
        }

        $this->editingTableId = null;
        $this->dispatch('toast', message: 'Meja disimpan.', type: 'success');
    }

    public function deleteTable(string $tableId): void
    {
        $table = RestaurantTable::findOrFail($tableId);

        if ($table->status === 'OCCUPIED') {
            $this->dispatch('toast', message: 'Meja sedang ditempati, tidak bisa dihapus.', type: 'error');
            return;
        }

        $table->delete();
        $this->dispatch('toast', message: 'Meja dihapus.', type: 'success');
    }

    public function render()
    {
        $branches = Branch::withCount(['users', 'orders', 'tables'])->orderBy('name')->get();

        $tables = collect();
        if ($this->selectedBranchId) {
            $tables = RestaurantTable::where('branch_id', $this->selectedBranchId)->orderBy('table_number')->get();
        }

        return view('livewire.admin.branches', [
            'branches' => $branches,
            'tables' => $tables,
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Cabang & Meja',
            'pageActions' => '<button wire:click="openCreate" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition">+ Tambah Cabang</button>',
        ]);
    }
}
