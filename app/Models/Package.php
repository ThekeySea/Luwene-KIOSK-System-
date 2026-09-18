<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'code', 'description', 'price', 'image', 'is_active'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function items()
    {
        return $this->hasMany(PackageItem::class)->orderBy('sort_order');
    }
}
