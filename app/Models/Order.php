<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasUuids;

    protected $fillable = [
        'branch_id', 'user_id', 'customer_name', 'customer_email', 'customer_phone',
        'table_id', 'dining_session_id',
        'client_order_id', 'order_number', 'order_mode', 'status', 'payment_status',
        'subtotal', 'tax_amount', 'discount_amount', 'total_amount',
        'notes', 'cancelled_at', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'cancelled_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id');
    }

    public function diningSession()
    {
        return $this->belongsTo(DiningSession::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function canTransitionTo(string $newStatus): bool
    {
        return match($this->status) {
            'PENDING' => in_array($newStatus, ['CONFIRMED', 'CANCELLED']),
            'CONFIRMED' => $newStatus === 'PREPARING',
            'PREPARING' => $newStatus === 'READY',
            'READY' => $newStatus === 'COMPLETED',
            default => false,
        };
    }
}
