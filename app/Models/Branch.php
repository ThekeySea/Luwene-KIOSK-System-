<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'address', 'status', 'latitude', 'longitude', 'delivery_fee', 'estimated_delivery_minutes'];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'delivery_fee' => 'decimal:2',
            'estimated_delivery_minutes' => 'integer',
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tables()
    {
        return $this->hasMany(RestaurantTable::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function diningSessions()
    {
        return $this->hasMany(DiningSession::class);
    }
}
