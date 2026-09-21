<?php

namespace App\Livewire\Delivery;

use Livewire\Component;

class BranchMenu extends Component
{
    public function mount(): void
    {
        redirect()->route('delivery.home');
    }

    public function render()
    {
        return view('livewire.delivery.branch-menu')->layout('components.layouts.delivery');
    }
}
