<?php

namespace App\Livewire\Delivery;

use Livewire\Component;

class EntryPage extends Component
{
    public function mount(): void
    {
        if (auth()->check()) {
            $this->redirect(route('delivery.home'), navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.delivery.entry-page')->layout('components.layouts.delivery');
    }
}
