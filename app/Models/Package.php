<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'code', 'description', 'price', 'image', 'is_active', 'is_published', 'is_published_delivery', 'type'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_published' => 'boolean',
            'is_published_delivery' => 'boolean',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(PackageItem::class)->orderBy('sort_order');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PackageSection::class)->orderBy('sort_order');
    }
}
