<?php

namespace App\Livewire\Customer;

use App\Models\Promo as PromoModel;
use App\Services\CartPricing;
use Illuminate\Support\Str;
use Livewire\Component;

class Promo extends Component
{
    public string $code = '';

    public function apply()
    {
        $this->validate(['code' => 'required|string|max:50']);

        $promo = PromoModel::where('code', Str::upper(trim($this->code)))->first();

        if (! $promo || ! $promo->isActive()) {
            $this->addError('code', 'Kode promo tidak valid atau sudah kedaluwarsa.');
            return;
        }

        if (CartPricing::subtotal() < (float) $promo->min_order_amount) {
            $this->addError('code', 'Belanja minimal Rp '.number_format((float) $promo->min_order_amount, 0, ',', '.').' untuk memakai kode ini.');
            return;
        }

        session()->put('promo_code', $promo->code);

        return redirect()->route('customer.cart');
    }

    public function remove(): void
    {
        session()->forget('promo_code');
    }

    public function render()
    {
        $code = session('promo_code');
        $applied = $code ? PromoModel::where('code', $code)->first() : null;

        return view('livewire.customer.promo', [
            'applied' => $applied,
        ])->layout('components.layouts.customer');
    }
}
