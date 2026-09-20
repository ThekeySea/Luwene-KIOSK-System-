<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class Settings extends Component
{
    public string $tax_rate = '11';
    public string $order_prefix = 'LW';
    public string $receipt_footer = '';
    public string $opening_hours = '08:00';
    public string $closing_hours = '22:00';

    public function mount(): void
    {
        $this->tax_rate = Setting::get('tax_rate', '11');
        $this->order_prefix = Setting::get('order_prefix', 'LW');
        $this->receipt_footer = Setting::get('receipt_footer', '');
        $this->opening_hours = Setting::get('opening_hours', '08:00');
        $this->closing_hours = Setting::get('closing_hours', '22:00');
    }

    protected function rules(): array
    {
        return [
            'tax_rate' => 'required|numeric|min:0|max:100',
            'order_prefix' => 'required|string|max:10',
            'receipt_footer' => 'nullable|string|max:255',
            'opening_hours' => 'required|date_format:H:i',
            'closing_hours' => 'required|date_format:H:i|after_or_equal:opening_hours',
        ];
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('tax_rate', $this->tax_rate);
        Setting::set('order_prefix', strtoupper(trim($this->order_prefix)));
        Setting::set('receipt_footer', trim($this->receipt_footer));
        Setting::set('opening_hours', $this->opening_hours);
        Setting::set('closing_hours', $this->closing_hours);

        $this->dispatch('toast', message: 'Pengaturan disimpan.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.settings')->layout('components.layouts.admin', [
            'pageTitle' => 'Pengaturan',
        ]);
    }
}
