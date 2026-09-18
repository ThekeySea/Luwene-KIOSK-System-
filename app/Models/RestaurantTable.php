<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class RestaurantTable extends Model
{
    use HasFactory;

    protected $table = 'restaurant_tables';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    protected static function booted(): void
    {
        static::creating(function (RestaurantTable $model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function diningSessions(): HasMany
    {
        return $this->hasMany(DiningSession::class, 'table_id');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'AVAILABLE';
    }

    public function isOccupied(): bool
    {
        return $this->status === 'OCCUPIED';
    }
}
