<?php

namespace Tests\Feature;

use App\Dtos\OrderData;
use App\Models\User;
use App\Services\OrderProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateDeliveryOrder()
    {
        // Mock HTTP response
        Http::fake([
            '*' => Http::response(['price' => 20], 200),
        ]);

        // Mock User
        $user = User::factory()->create([
            'loyalty_points' => 100
        ]);

        // Create OrderProcessor instance
        $orderProcessor = new OrderProcessor();

        // Process delivery order
        $orderProcessor->processOrder(new OrderData($user, 'delivery', 10, true));

        // Assert that the order was created with correct total price
        // Assuming delivery cost is 10 (10 * 1) and loyalty points worth 1 zł (100 / 100)
        $this->assertDatabaseHas('orders', [
            'type' => 'delivery',
            'total_price' => 10 + 20 - 1, // delivery_cost + price - loyalty_points
        ]);
    }

    public function testCreateTakeawayOrder(): void
    {
        // Mock HTTP response
        Http::fake([
            '*' => Http::response(['price' => 15], 200),
        ]);

        // Mock User
        $user = User::factory()->create([
            'loyalty_points' => 100
        ]);

        // Create OrderProcessor instance
        $orderProcessor = new OrderProcessor();

        // Process takeaway order
        $orderProcessor->processOrder(new OrderData($user, 'takeaway', 10, true));

        // Assert that the order was created with correct total price
        // Assuming loyalty points worth 1 zł (100 / 100)
        $this->assertDatabaseHas('orders', [
            'type' => 'takeaway',
            'price' => 15, // price - loyalty_points can not be used!
        ]);
    }

    public function testCreateDineInOrder(): void
    {
        // Mock HTTP response
        Http::fake([
            '*' => Http::response(['price' => 30], 200),
        ]);

        // Mock User
        $user = User::factory()->create([
            'loyalty_points' => 100
        ]);

        // Create OrderProcessor instance
        $orderProcessor = new OrderProcessor();

        // Process dine-in order
        $orderProcessor->processOrder(new OrderData($user, 'dine_in', 10, true));

        // Assert that the order was created with correct total price
        // Assuming loyalty points worth 1 zł (100 / 100)
        $this->assertDatabaseHas('orders', [
            'type' => 'dine_in',
            'price' => 30 - 1, // price - loyalty_points
        ]);
    }
}
