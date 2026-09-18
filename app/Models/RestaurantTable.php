<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    use HasUuids;

    protected $fillable = ['branch_id', 'table_number', 'capacity', 'status'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id');
    }

    public function diningSessions()
    {
        return $this->hasMany(DiningSession::class, 'table_id');
    }
}
