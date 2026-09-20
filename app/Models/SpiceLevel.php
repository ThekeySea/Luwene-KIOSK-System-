<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpiceLevel extends Model
{
    use HasUuids;

    protected $fillable = ['sambal_id', 'name', 'level', 'description', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function sambal(): BelongsTo
    {
        return $this->belongsTo(Sambal::class);
    }
}
