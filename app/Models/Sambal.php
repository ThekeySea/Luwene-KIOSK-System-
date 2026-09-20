<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sambal extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'description', 'price', 'is_available', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_available' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function spiceLevels(): HasMany
    {
        return $this->hasMany(SpiceLevel::class)->orderBy('sort_order');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_sambals')
            ->withPivot('price', 'is_required', 'sort_order')
            ->orderByPivot('sort_order');
    }
}
