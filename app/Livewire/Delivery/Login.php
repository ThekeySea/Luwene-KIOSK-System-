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

            if ($user->role !== 'CUSTOMER') {
                Auth::logout();
                $this->addError('email', 'Akun ini bukan akun pelanggan.');
                return;
            }

            $user->update(['last_login_at' => now()]);
            session()->regenerate();

            return redirect()->route('delivery.home');
        }

        $this->addError('email', 'Email atau password salah.');
        $this->reset('password');
    }

    public function render()
    {
        return view('livewire.delivery.login')->layout('components.layouts.delivery');
    }
}
