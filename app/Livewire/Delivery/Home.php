<?php

namespace App\Livewire\Delivery;

use App\Models\Branch;
use App\Services\DistanceService;
use Livewire\Component;

class Home extends Component
{
    public float $userLat = -7.2575;
    public float $userLng = 112.7522;
    public string $search = '';

    protected $listeners = ['setLocation' => 'setLocation'];

    public function setLocation(float $lat, float $lng): void
    {
        $this->userLat = $lat;
        $this->userLng = $lng;
        session()->put('delivery_lat', $lat);
        session()->put('delivery_lng', $lng);
    }

    public function render()
    {
        if (session('delivery_lat') && session('delivery_lng')) {
            $this->userLat = session('delivery_lat');
            $this->userLng = session('delivery_lng');
        }

        $branches = Branch::where('status', 'ACTIVE')
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->get()
            ->map(fn ($branch) => [
                'id' => $branch->id,
                'name' => $branch->name,
                'address' => $branch->address,
                'delivery_fee' => $branch->delivery_fee,
                'estimated_delivery_minutes' => $branch->estimated_delivery_minutes,
                'latitude' => $branch->latitude,
                'longitude' => $branch->longitude,
                'distance_km' => $branch->latitude && $branch->longitude
                    ? DistanceService::haversine($this->userLat, $this->userLng, $branch->latitude, $branch->longitude)
                    : null,
                'distance_label' => $branch->latitude && $branch->longitude
                    ? DistanceService::distanceInKm($this->userLat, $this->userLng, $branch->latitude, $branch->longitude)
                    : null,
            ])
            ->sortBy('distance_km')
            ->values();

        return view('livewire.delivery.home', [
            'branches' => $branches,
            'user' => auth()->user(),
        ])->layout('components.layouts.delivery');
    }
}
