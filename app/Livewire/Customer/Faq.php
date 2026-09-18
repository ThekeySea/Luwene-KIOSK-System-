<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class Faq extends Component
{
    public function render()
    {
        return view('livewire.customer.faq')->layout('components.layouts.customer');
    }
}
