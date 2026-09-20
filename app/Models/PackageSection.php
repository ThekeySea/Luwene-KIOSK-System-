<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PackageSection extends Model
{
    use HasUuids;

    protected $fillable = ['package_id', 'name', 'choice_type', 'max_pick', 'sort_order'];

    protected function casts(): array
    {
        return [
            'max_pick' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PackageItem::class, 'package_section_id')->orderBy('sort_order');
    }
}
