<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SpiceLevel extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'level', 'description', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
