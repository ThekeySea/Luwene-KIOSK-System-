<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'image',
        'base_price', 'is_active', 'is_available', 'is_featured', 'is_published', 'is_published_delivery', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'is_published_delivery' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    public function modifierGroups()
    {
        return $this->belongsToMany(ModifierGroup::class, 'product_modifier_groups')
            ->withPivot('is_required', 'min_selection', 'max_selection', 'sort_order')
            ->orderByPivot('sort_order');
    }

    public function sambals()
    {
        return $this->belongsToMany(Sambal::class, 'product_sambals')
            ->withPivot('price', 'is_required', 'sort_order')
            ->orderByPivot('sort_order');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function packageItems()
    {
        return $this->hasMany(PackageItem::class);
    }
}
