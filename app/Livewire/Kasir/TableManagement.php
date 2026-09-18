<?php

namespace App\Livewire\Kasir;

use App\Models\RestaurantTable;
use Livewire\Component;

class TableManagement extends Component
{
    public array $tables = [];

    public function mount(): void
    {
        $this->loadTables();
    }

    public function loadTables(): void
    {
        $this->tables = RestaurantTable::with('diningSessions')
            ->orderBy('table_number')
            ->get()
            ->toArray();
    }

    public function toggleStatus(string $tableId): void
    {
        $table = RestaurantTable::findOrFail($tableId);
        $newStatus = $table->status === 'AVAILABLE' ? 'OCCUPIED' : 'AVAILABLE';
        $table->update(['status' => $newStatus]);
        $this->loadTables();
    }

    public function render()
    {
        return view('livewire.kasir.table-management')->layout('layouts.staff');
    }
}
