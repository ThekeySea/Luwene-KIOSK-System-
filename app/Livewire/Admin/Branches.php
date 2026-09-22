<?php

namespace App\Livewire\Admin;

use App\Models\Branch;
use App\Models\RestaurantTable;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Branches extends Component
{
    // Branch info
    public ?string $editingId = null;
    public string $name = '';
    public string $address = '';
    public string $latitude = '';
    public string $longitude = '';
    public string $delivery_fee = '5000';
    public string $estimated_delivery_minutes = '30';

    // Table management
    public bool $showTableModal = false;
    public ?string $editingTableId = null;
    public ?string $confirmingDeleteTable = null;
    public string $table_number = '';
    public string $capacity = '4';
    public string $status = 'AVAILABLE';

    // Bulk add
    public bool $showBulkModal = false;
    public string $bulkStart = '1';
    public string $bulkEnd = '10';
    public string $bulkCapacity = '4';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'delivery_fee' => 'required|numeric|min:0',
            'estimated_delivery_minutes' => 'required|integer|min:5|max:120',
            // Table rules
            'table_number' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1|max:100',
            'status' => 'required|in:AVAILABLE,OCCUPIED,RESERVED',
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

    // ─── Table Management ───────────────────────────────────────────

    public function openCreateTable(): void
    {
        $this->reset(['editingTableId', 'table_number', 'capacity', 'status', 'confirmingDeleteTable']);
        $this->capacity = '4';
        $this->status = 'AVAILABLE';

        $branchId = Auth::user()->branch_id;
        $last = RestaurantTable::where('branch_id', $branchId)
            ->orderByDesc('table_number')
            ->first();
        $this->table_number = (string) (($last->table_number ?? 0) + 1);

        $this->resetErrorBag();
        $this->showTableModal = true;
    }

    public function openEditTable(string $id): void
    {
        $table = RestaurantTable::findOrFail($id);

        $this->editingTableId = $table->id;
        $this->table_number = (string) $table->table_number;
        $this->capacity = (string) $table->capacity;
        $this->status = $table->status;
        $this->confirmingDeleteTable = null;
        $this->resetErrorBag();
        $this->showTableModal = true;
    }

    public function saveTable(): void
    {
        $this->validate();

        $branchId = Auth::user()->branch_id;

        $exists = RestaurantTable::where('branch_id', $branchId)
            ->where('table_number', (int) $this->table_number);
        if ($this->editingTableId) {
            $exists->where('id', '!=', $this->editingTableId);
        }
        if ($exists->exists()) {
            $this->addError('table_number', 'Nomor meja sudah digunakan.');
            return;
        }

        $data = [
            'branch_id' => $branchId,
            'table_number' => (int) $this->table_number,
            'capacity' => (int) $this->capacity,
            'status' => $this->status,
        ];

        if ($this->editingTableId) {
            RestaurantTable::findOrFail($this->editingTableId)->update($data);
        } else {
            RestaurantTable::create($data);
        }

        $this->showTableModal = false;
        $this->dispatch('toast', message: 'Meja disimpan.', type: 'success');
    }

    public function destroyTable(string $id): void
    {
        $table = RestaurantTable::withCount('orders')->findOrFail($id);

        if ($table->orders_count > 0) {
            $this->dispatch('toast', message: 'Meja masih memiliki riwayat pesanan, tidak bisa dihapus.', type: 'error');
            $this->confirmingDeleteTable = null;
            return;
        }

        $table->delete();
        $this->confirmingDeleteTable = null;
        $this->dispatch('toast', message: 'Meja dihapus.', type: 'success');
    }

    public function openBulk(): void
    {
        $branchId = Auth::user()->branch_id;
        $last = RestaurantTable::where('branch_id', $branchId)
            ->orderByDesc('table_number')
            ->first();
        $this->bulkStart = (string) (($last->table_number ?? 0) + 1);
        $this->bulkEnd = (string) (($last->table_number ?? 0) + 10);
        $this->bulkCapacity = '4';
        $this->resetErrorBag();
        $this->showBulkModal = true;
    }

    public function saveBulk(): void
    {
        $start = (int) $this->bulkStart;
        $end = (int) $this->bulkEnd;
        $capacity = (int) $this->bulkCapacity;

        if ($start < 1 || $end < $start || $capacity < 1) {
            $this->dispatch('toast', message: 'Input tidak valid.', type: 'error');
            return;
        }

        $branchId = Auth::user()->branch_id;
        $existing = RestaurantTable::where('branch_id', $branchId)
            ->pluck('table_number')
            ->toArray();
        $existingNumbers = range($start, $end);
        $conflicts = array_intersect($existingNumbers, $existing);

        if ($conflicts !== []) {
            $this->dispatch('toast', message: 'Nomor meja '.implode(', ', $conflicts).' sudah ada.', type: 'error');
            return;
        }

        $created = 0;
        for ($i = $start; $i <= $end; $i++) {
            RestaurantTable::create([
                'branch_id' => $branchId,
                'table_number' => $i,
                'capacity' => $capacity,
                'status' => 'AVAILABLE',
            ]);
            $created++;
        }

        $this->showBulkModal = false;
        $this->dispatch('toast', message: "{$created} meja berhasil ditambahkan.", type: 'success');
    }

    // ─── Render ─────────────────────────────────────────────────────

    public function render()
    {
        $branch = Branch::first();
        $branchId = Auth::user()->branch_id;

        $tables = RestaurantTable::where('branch_id', $branchId)
            ->orderBy('table_number')
            ->get();

        $staffCount = $branch ? \App\Models\User::where('role', '!=', 'CUSTOMER')->count() : 0;
        $orderCount = $branch ? $branch->orders()->count() : 0;

        return view('livewire.admin.branches', [
            'branch' => $branch,
            'tables' => $tables,
            'tableCount' => $tables->count(),
            'availableCount' => $tables->where('status', 'AVAILABLE')->count(),
            'occupiedCount' => $tables->where('status', 'OCCUPIED')->count(),
            'staffCount' => $staffCount,
            'orderCount' => $orderCount,
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Info Restoran',
        ]);
    }
}
