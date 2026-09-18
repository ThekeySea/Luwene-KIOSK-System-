<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ModifierGroup extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'description', 'type', 'min_selection', 'max_selection', 'is_required', 'sort_order'];

    public function modifiers()
    {
        return $this->hasMany(Modifier::class)->orderBy('sort_order');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_modifier_groups')
            ->withPivot('is_required', 'min_selection', 'max_selection', 'sort_order');
    }
}
