<?php

namespace App\Livewire\Customer;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\RestaurantTable;
use App\Models\DiningSession;
use Illuminate\Support\Str;
use Livewire\Component;

class EntryPage extends Component
{
    public string $orderMode = '';

    public function selectDineIn()
    {
        $this->orderMode = 'DINE_IN';
    }

    public function selectTakeAway()
    {
        session()->put('order_mode', 'TAKE_AWAY');
        session()->put('table_id', null);
        session()->put('dining_session_id', null);

        return redirect()->route('customer.menu');
    }

    public function selectDelivery()
    {
        return redirect()->route('delivery.entry');
    }

    public function selectTable(string $tableId)
    {
        $table = RestaurantTable::findOrFail($tableId);

        if ($table->status !== 'AVAILABLE') {
            session()->flash('error', 'Meja ini sudah terisi.');
            return;
        }

        $session = DiningSession::create([
            'branch_id' => $table->branch_id,
            'table_id' => $table->id,
            'order_mode' => 'DINE_IN',
            'session_token' => Str::uuid()->toString(),
            'status' => 'ACTIVE',
        ]);

        $table->update(['status' => 'OCCUPIED']);

        session()->put('order_mode', 'DINE_IN');
        session()->put('table_id', $table->id);
        session()->put('table_number', $table->table_number);
        session()->put('dining_session_id', $session->id);

        return redirect()->route('customer.menu');
    }

    public function render()
    {
        $tables = RestaurantTable::orderBy('table_number')->get();

        $popularProducts = Product::where('is_active', true)
            ->where('is_published', true)
            ->withCount(['orderItems as orders_count' => function ($q) {
                $q->whereHas('order', fn ($oq) => $oq->where('status', 'COMPLETED'));
            }])
            ->orderBy('orders_count', 'desc')
            ->limit(3)
            ->get();

        return view('livewire.customer.entry-page', [
            'tables' => $tables,
            'popularProducts' => $popularProducts,
        ])->layout('components.layouts.customer', ['showNav' => false]);
    }
}
