<?php

namespace App\Livewire\Delivery;

use App\Models\DeliveryAddress;
use Livewire\Component;

class Profile extends Component
{
    public bool $showAddressModal = false;
    public ?string $editingAddressId = null;
    public string $label = '';
    public string $address = '';
    public string $latitude = '';
    public string $longitude = '';
    public bool $isDefault = false;
    public bool $isDeleting = false;
    public ?string $deleteAddressId = null;

    protected array $rules = [
        'label' => 'required|string|max:50',
        'address' => 'required|string|max:255',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
    ];

    public function openAddModal(): void
    {
        $this->resetAddressForm();
        $this->showAddressModal = true;
    }

    public function openEditModal(string $addressId): void
    {
        $address = DeliveryAddress::where('user_id', auth()->id())->find($addressId);
        if (! $address) return;

        $this->editingAddressId = $address->id;
        $this->label = $address->label;
        $this->address = $address->address;
        $this->latitude = $address->latitude ? (string) $address->latitude : '';
        $this->longitude = $address->longitude ? (string) $address->longitude : '';
        $this->isDefault = $address->is_default;
        $this->showAddressModal = true;
    }

    public function saveAddress(): void
    {
        $this->validate();

        $data = [
            'label' => $this->label,
            'address' => $this->address,
            'latitude' => $this->latitude !== '' ? (float) $this->latitude : null,
            'longitude' => $this->longitude !== '' ? (float) $this->longitude : null,
            'is_default' => $this->isDefault,
        ];

        if ($this->isDefault) {
            DeliveryAddress::where('user_id', auth()->id())->where('is_default', true)->update(['is_default' => false]);
        }

        if ($this->editingAddressId) {
            DeliveryAddress::where('user_id', auth()->id())->find($this->editingAddressId)?->update($data);
            $this->dispatch('toast', message: 'Alamat berhasil diperbarui.', type: 'success');
        } else {
            $hasAny = DeliveryAddress::where('user_id', auth()->id())->exists();
            if (! $hasAny) {
                $data['is_default'] = true;
            }
            DeliveryAddress::create(array_merge($data, ['user_id' => auth()->id()]));
            $this->dispatch('toast', message: 'Alamat berhasil ditambahkan.', type: 'success');
        }

        $this->showAddressModal = false;
        $this->resetAddressForm();
    }

    public function confirmDelete(string $addressId): void
    {
        $this->deleteAddressId = $addressId;
        $this->isDeleting = true;
    }

    public function cancelDelete(): void
    {
        $this->deleteAddressId = null;
        $this->isDeleting = false;
    }

    public function deleteAddress(): void
    {
        $address = DeliveryAddress::where('user_id', auth()->id())->find($this->deleteAddressId);
        if ($address) {
            $wasDefault = $address->is_default;
            $address->delete();

            if ($wasDefault) {
                $first = DeliveryAddress::where('user_id', auth()->id())->first();
                if ($first) {
                    $first->update(['is_default' => true]);
                }
            }

            $this->dispatch('toast', message: 'Alamat dihapus.', type: 'success');
        }

        $this->deleteAddressId = null;
        $this->isDeleting = false;
    }

    public function setDefault(string $addressId): void
    {
        DeliveryAddress::where('user_id', auth()->id())->where('is_default', true)->update(['is_default' => false]);
        DeliveryAddress::where('user_id', auth()->id())->find($addressId)?->update(['is_default' => true]);
        $this->dispatch('toast', message: 'Alamat utama diubah.', type: 'success');
    }

    private function resetAddressForm(): void
    {
        $this->editingAddressId = null;
        $this->label = '';
        $this->address = '';
        $this->latitude = '';
        $this->longitude = '';
        $this->isDefault = false;
        $this->resetValidation();
    }

    public function render()
    {
        $user = auth()->user();
        $addresses = DeliveryAddress::where('user_id', $user->id)->orderByDesc('is_default')->get();
        $orderCount = \App\Models\Order::where('user_id', $user->id)->where('order_mode', 'DELIVERY')->count();

        return view('livewire.delivery.profile', [
            'user' => $user,
            'addresses' => $addresses,
            'orderCount' => $orderCount,
        ])->layout('components.layouts.delivery');
    }
}
