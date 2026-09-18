<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    use HasUuids;

    protected $fillable = ['modifier_group_id', 'name', 'price', 'is_available', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_available' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function modifierGroup()
    {
        return $this->belongsTo(ModifierGroup::class);
    }
}
