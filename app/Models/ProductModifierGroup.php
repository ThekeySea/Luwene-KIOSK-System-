<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProductModifierGroup extends Model
{
    use HasUuids;

    protected $fillable = ['product_id', 'modifier_group_id', 'is_required', 'min_selection', 'max_selection', 'sort_order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function modifierGroup()
    {
        return $this->belongsTo(ModifierGroup::class);
    }
}
