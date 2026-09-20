<?php

namespace App\Livewire\Customer;

use App\Models\Package;
use Livewire\Component;

class Packages extends Component
{
    public function render()
    {
        $packages = Package::withCount('items')
            ->where('is_active', true)
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.customer.packages', [
            'packages' => $packages,
        ])->layout('components.layouts.customer');
    }
}
