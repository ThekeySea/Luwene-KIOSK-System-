<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OrderItemModifier extends Model
{
    use HasUuids;

    protected $fillable = ['order_item_id', 'modifier_id', 'modifier_name', 'modifier_type', 'price'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function modifier()
    {
        return $this->belongsTo(Modifier::class);
    }
}
