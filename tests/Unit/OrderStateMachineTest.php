<?php

namespace Tests\Unit;

use App\Models\Branch;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderStateMachineTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrder(string $status): Order
    {
        $branch = Branch::create(['name' => 'Test Branch', 'status' => 'ACTIVE']);

        return Order::create([
            'branch_id' => $branch->id,
            'client_order_id' => (string) \Illuminate\Support\Str::uuid(),
            'order_number' => 'LW-TEST',
            'order_mode' => 'TAKE_AWAY',
            'status' => $status,
        ]);
    }

    public function test_pending_can_transition_to_confirmed(): void
    {
        $order = $this->makeOrder('PENDING');
        $this->assertTrue($order->canTransitionTo('CONFIRMED'));
    }

    public function test_pending_can_transition_to_cancelled(): void
    {
        $order = $this->makeOrder('PENDING');
        $this->assertTrue($order->canTransitionTo('CANCELLED'));
    }

    public function test_pending_cannot_transition_to_preparing(): void
    {
        $order = $this->makeOrder('PENDING');
        $this->assertFalse($order->canTransitionTo('PREPARING'));
    }

    public function test_pending_cannot_transition_to_ready(): void
    {
        $order = $this->makeOrder('PENDING');
        $this->assertFalse($order->canTransitionTo('READY'));
    }

    public function test_pending_cannot_transition_to_completed(): void
    {
        $order = $this->makeOrder('PENDING');
        $this->assertFalse($order->canTransitionTo('COMPLETED'));
    }

    public function test_confirmed_can_transition_to_preparing(): void
    {
        $order = $this->makeOrder('CONFIRMED');
        $this->assertTrue($order->canTransitionTo('PREPARING'));
    }

    public function test_confirmed_cannot_transition_to_pending(): void
    {
        $order = $this->makeOrder('CONFIRMED');
        $this->assertFalse($order->canTransitionTo('PENDING'));
    }

    public function test_confirmed_cannot_transition_to_completed(): void
    {
        $order = $this->makeOrder('CONFIRMED');
        $this->assertFalse($order->canTransitionTo('COMPLETED'));
    }

    public function test_preparing_can_transition_to_ready(): void
    {
        $order = $this->makeOrder('PREPARING');
        $this->assertTrue($order->canTransitionTo('READY'));
    }

    public function test_preparing_cannot_transition_to_confirmed(): void
    {
        $order = $this->makeOrder('PREPARING');
        $this->assertFalse($order->canTransitionTo('CONFIRMED'));
    }

    public function test_preparing_cannot_transition_to_completed(): void
    {
        $order = $this->makeOrder('PREPARING');
        $this->assertFalse($order->canTransitionTo('COMPLETED'));
    }

    public function test_ready_can_transition_to_completed(): void
    {
        $order = $this->makeOrder('READY');
        $this->assertTrue($order->canTransitionTo('COMPLETED'));
    }

    public function test_ready_cannot_transition_to_preparing(): void
    {
        $order = $this->makeOrder('READY');
        $this->assertFalse($order->canTransitionTo('PREPARING'));
    }

    public function test_ready_cannot_transition_to_pending(): void
    {
        $order = $this->makeOrder('READY');
        $this->assertFalse($order->canTransitionTo('PENDING'));
    }

    public function test_completed_cannot_transition_anywhere(): void
    {
        $order = $this->makeOrder('COMPLETED');
        $this->assertFalse($order->canTransitionTo('PENDING'));
        $this->assertFalse($order->canTransitionTo('CONFIRMED'));
        $this->assertFalse($order->canTransitionTo('PREPARING'));
        $this->assertFalse($order->canTransitionTo('READY'));
        $this->assertFalse($order->canTransitionTo('CANCELLED'));
    }

    public function test_cancelled_cannot_transition_anywhere(): void
    {
        $order = $this->makeOrder('CANCELLED');
        $this->assertFalse($order->canTransitionTo('PENDING'));
        $this->assertFalse($order->canTransitionTo('CONFIRMED'));
        $this->assertFalse($order->canTransitionTo('PREPARING'));
        $this->assertFalse($order->canTransitionTo('READY'));
        $this->assertFalse($order->canTransitionTo('COMPLETED'));
    }

    public function test_full_happy_path(): void
    {
        $order = $this->makeOrder('PENDING');

        $this->assertTrue($order->canTransitionTo('CONFIRMED'));
        $order->status = 'CONFIRMED';
        $order->save();

        $this->assertTrue($order->canTransitionTo('PREPARING'));
        $order->status = 'PREPARING';
        $order->save();

        $this->assertTrue($order->canTransitionTo('READY'));
        $order->status = 'READY';
        $order->save();

        $this->assertTrue($order->canTransitionTo('COMPLETED'));
        $order->status = 'COMPLETED';
        $order->completed_at = now();
        $order->save();

        $this->assertEquals('COMPLETED', $order->fresh()->status);
    }
}
