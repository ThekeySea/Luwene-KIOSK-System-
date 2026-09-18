<?php

namespace App\Livewire\Customer;

use App\Models\Branch;
use App\Models\DiningSession;
use App\Models\RestaurantTable;
use Livewire\Component;

class EntryPage extends Component
{
    public ?string $selectedMode = null;
    public ?string $qrToken = null;
    public ?string $scannedTableId = null;
    public ?string $scannedTableName = null;
    public string $manualTableNumber = '';
    public ?string $error = null;

    public function mount(): void
    {
        if (session('order_mode')) {
            $this->redirectRoute('customer.menu');
            return;
        }

        $this->qrToken = request()->query('qr');
        if ($this->qrToken) {
            $this->resolveQrToken();
        }
    }

    public function resolveQrToken(): void
    {
        $branch = Branch::where('status', 'ACTIVE')->first();
        if (!$branch) {
            $this->error = 'Tidak ada restoran aktif.';
            return;
        }

        $table = RestaurantTable::where('branch_id', $branch->id)
            ->where('qr_token_hash', $this->qrToken)
            ->first();

        if (!$table) {
            $this->error = 'QR Code tidak valid.';
            return;
        }

        if ($table->status === 'INACTIVE') {
            $this->error = 'Meja tidak aktif.';
            return;
        }

        $this->scannedTableId = $table->id;
        $this->scannedTableName = $table->table_number;
        $this->selectedMode = 'DINE_IN';
    }

    public function selectDineIn(): void
    {
        $this->selectedMode = 'DINE_IN';
    }

    public function selectTakeAway(): void
    {
        $this->selectedMode = 'TAKE_AWAY';
    }

    public function confirmDineIn(): void
    {
        if (!$this->scannedTableId) {
            $this->error = 'Silakan scan QR meja terlebih dahulu.';
            return;
        }

        $branch = Branch::where('status', 'ACTIVE')->first();
        $table = RestaurantTable::find($this->scannedTableId);

        $session = DiningSession::where('table_id', $table->id)
            ->where('status', 'OPEN')
            ->first();

        if (!$session) {
            $session = DiningSession::create([
                'branch_id' => $branch->id,
                'table_id' => $table->id,
                'opened_at' => now(),
                'status' => 'OPEN',
            ]);
        }

        session([
            'order_mode' => 'DINE_IN',
            'table_id' => $table->id,
            'table_name' => $table->table_number,
            'dining_session_id' => $session->id,
        ]);

        $this->redirectRoute('customer.menu');
    }

    public function confirmTakeAway(): void
    {
        session([
            'order_mode' => 'TAKE_AWAY',
            'table_id' => null,
            'table_name' => null,
            'dining_session_id' => null,
        ]);

        $this->redirectRoute('customer.menu');
    }

    public function render()
    {
        return view('livewire.customer.entry-page')->layout('layouts.customer');
    }
}
