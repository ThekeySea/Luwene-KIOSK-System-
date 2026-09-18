<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected array $rules = [
        'email' => 'required|email',
        'password' => 'required|min:1',
    ];

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            $user = Auth::user();

            $user->update(['last_login_at' => now()]);

            session()->regenerate();
            session()->put('active_branch_id', $user->branch_id);

            return match($user->role) {
                'ADMIN' => redirect()->route('admin.dashboard'),
                'CASHIER' => redirect()->route('cashier.dashboard'),
                'CUSTOMER' => redirect()->route('customer.dashboard'),
                default => redirect()->route('login'),
            };
        }

        $this->addError('email', 'Email atau password salah.');

        $this->reset('password');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.customer', ['showNav' => false]);
    }
}
