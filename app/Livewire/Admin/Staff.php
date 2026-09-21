<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Staff extends Component
{
    public string $roleFilter = '';

    public bool $showModal = false;
    public ?string $editingId = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'CASHIER';
    public string $status = 'ACTIVE';

    protected function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($this->editingId)],
            'role' => 'required|in:CASHIER,ADMIN',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ];

        if (! $this->editingId || $this->password !== '') {
            $rules['password'] = 'required|string|min:8';
        }

        return $rules;
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'email', 'password']);
        $this->role = 'CASHIER';
        $this->status = 'ACTIVE';
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(string $id): void
    {
        $user = User::findOrFail($id);

        if ($user->role === 'CUSTOMER') {
            $this->dispatch('toast', message: 'Akun pelanggan tidak bisa diubah di sini.', type: 'error');
            return;
        }

        $this->editingId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->role = $user->role;
        $this->status = $user->status ?? 'ACTIVE';
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => trim($this->name),
            'email' => trim($this->email),
            'role' => $this->role,
            'status' => $this->status,
        ];

        if (! $this->editingId || $this->password !== '') {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editingId) {
            if ($this->editingId === auth()->id() && $this->status === 'INACTIVE') {
                $this->addError('status', 'Tidak bisa menonaktifkan akun sendiri.');
                return;
            }
            User::findOrFail($this->editingId)->update($data);
        } else {
            User::create($data);
        }

        $this->showModal = false;
        $this->dispatch('toast', message: 'Data staff disimpan.', type: 'success');
    }

    public function toggleStatus(string $id): void
    {
        if ($id === auth()->id()) {
            $this->dispatch('toast', message: 'Tidak bisa menonaktifkan akun sendiri.', type: 'error');
            return;
        }

        $user = User::findOrFail($id);
        $user->update(['status' => ($user->status ?? 'ACTIVE') === 'ACTIVE' ? 'INACTIVE' : 'ACTIVE']);
        $this->dispatch('toast', message: "Status {$user->name} diubah.", type: 'success');
    }

    public function render()
    {
        $staff = User::with('branch')
            ->whereIn('role', ['CASHIER', 'ADMIN'])
            ->when($this->roleFilter !== '', fn ($q) => $q->where('role', $this->roleFilter))
            ->orderBy('name')
            ->get();

        $customerCount = User::where('role', 'CUSTOMER')->count();

        return view('livewire.admin.staff', [
            'staff' => $staff,
            'customerCount' => $customerCount,
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Staff',
            'pageActions' => '<button wire:click="openCreate" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition">+ Tambah Staff</button>',
        ]);
    }
}
