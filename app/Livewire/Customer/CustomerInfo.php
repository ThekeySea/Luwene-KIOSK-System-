<?php

namespace App\Livewire\Customer;

use App\Services\CartPricing;
use Livewire\Component;

class CustomerInfo extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';

    public function mount(): void
    {
        $this->name = (string) session('customer_name', '');
        $this->email = (string) session('customer_email', '');
        $this->phone = (string) session('customer_phone', '');
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => ['required', 'regex:/^[0-9+\-\s()]{9,18}$/'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Nomor telepon tidak valid.',
        ];
    }

    public function save()
    {
        $this->validate();

        session()->put('customer_name', trim($this->name));
        session()->put('customer_email', trim($this->email));
        session()->put('customer_phone', trim($this->phone));

        return redirect()->route('customer.checkout');
    }

    public function render()
    {
        return view('livewire.customer.info', [
            'hasItems' => count(CartPricing::items()) > 0,
        ])->layout('components.layouts.customer', ['showNav' => false]);
    }
}
