<?php

namespace App\Livewire\Delivery;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';

    protected array $rules = [
        'email' => 'required|email',
        'password' => 'required|min:1',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();

            $user->update(['last_login_at' => now()]);
            session()->regenerate();

            return match ($user->role) {
                'ADMIN' => redirect()->route('admin.dashboard'),
                'CASHIER' => redirect()->route('cashier.dashboard'),
                'CUSTOMER' => redirect()->route('delivery.home'),
                default => redirect()->route('delivery.entry'),
            };
        }

        $this->addError('email', 'Email atau password salah.');
        $this->reset('password');
    }

    public function render()
    {
        return view('livewire.delivery.login')->layout('components.layouts.delivery');
    }
}
