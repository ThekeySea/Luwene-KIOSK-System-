<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PackageItem extends Model
{
    use HasUuids;

    protected $fillable = ['package_id', 'product_id', 'quantity', 'role', 'is_required', 'sort_order'];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'is_required' => 'boolean',
        ];
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
