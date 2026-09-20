<?php

namespace App\Livewire\Delivery;

use Livewire\Component;

class EntryPage extends Component
{
    public function render()
    {
        if (auth()->check()) {
            return redirect()->route('delivery.home');
        }

        return view('livewire.delivery.entry-page')->layout('components.layouts.delivery');
    }
}
