<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasUuids;

    protected $fillable = ['user_id', 'label', 'address', 'latitude', 'longitude', 'is_default'];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_default' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
