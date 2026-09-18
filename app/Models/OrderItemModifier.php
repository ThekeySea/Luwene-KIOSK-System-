<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class OrderItemModifier extends Model
{
    use HasFactory;

    protected $table = 'order_item_modifiers';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    protected static function booted(): void
    {
        static::creating(function (OrderItemModifier $model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function modifier(): BelongsTo
    {
        return $this->belongsTo(Modifier::class);
    }

    public function sambal(): BelongsTo
    {
        return $this->belongsTo(Sambal::class);
    }

    public function spiceLevel(): BelongsTo
    {
        return $this->belongsTo(SpiceLevel::class);
    }
}
