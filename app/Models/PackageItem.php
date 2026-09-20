<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageItem extends Model
{
    use HasUuids;

    protected $fillable = ['package_id', 'package_section_id', 'product_id', 'quantity', 'role', 'price_override', 'is_required', 'sort_order'];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price_override' => 'decimal:2',
            'is_required' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(PackageSection::class, 'package_section_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceAttribute(): float
    {
        return $this->price_override !== null ? (float) $this->price_override : (float) $this->product->base_price;
    }
}
