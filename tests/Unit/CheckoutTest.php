<?php

namespace Tests\Unit;

use App\Enums\OrderStrategiesEnum;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_authenticated_endpoint_place_order()
    {
        $response = $this->postJson('/api/checkout', []);
        $response->assertStatus(401);
    }

    /** @test */
    public function it_checks_checkout_taxes_and_service()
    {
        $table = Table::factory()->create(['capacity' => 4]);
        $user = User::factory()->create();
        $customer = $user->customer()->create(['phone' => '01112112985']);
        $WAITER = User::factory()->create((['role' => "WAITER"]));

        Passport::actingAs($WAITER);

        $reservation = Reservation::factory()->create([
            'table_id' => $table->id,
            'from_time' => Carbon::now()->addHours(1),
            'to_time' => Carbon::now()->addHours(2),
            'customer_id' => $customer->id,
            'date' => date('Y-m-d'),
        ]);

        $payload = [
            'table_id' => $table->id,
            'reservation_id' => $reservation->id,
            'customer_id' => $customer->id,
            'user_id' => $WAITER->id,
            'date' => Carbon::now()->toDateString(),
            'paid' => false,
            'total' => 200
        ];
        $order = Order::create($payload);

        $response = $this->postJson('/api/checkout', [
            'order_id' => $order->id,
            'checkout_type' => OrderStrategiesEnum::TAXES_AND_SERVICES
        ]);
        $response->assertStatus(200);
        $responseData = $response->json();
        $expectedSubTotal = 200;
        $expectedTotal = 200  * (1 + 0.14 + 0.20);
        $this->assertEquals($expectedSubTotal, $responseData['invoice']['sub_total']);
        $this->assertEquals($expectedTotal, $responseData['invoice']['total']);
    }

        /** @test */
        public function it_checks_checkout_services_only()
        {
            $table = Table::factory()->create(['capacity' => 4]);
            $user = User::factory()->create();
            $customer = $user->customer()->create(['phone' => '01112112985']);
            $WAITER = User::factory()->create((['role' => "WAITER"]));
    
            Passport::actingAs($WAITER);
    
            $reservation = Reservation::factory()->create([
                'table_id' => $table->id,
                'from_time' => Carbon::now()->addHours(1),
                'to_time' => Carbon::now()->addHours(2),
                'customer_id' => $customer->id,
                'date' => date('Y-m-d'),
            ]);
    
            $payload = [
                'table_id' => $table->id,
                'reservation_id' => $reservation->id,
                'customer_id' => $customer->id,
                'user_id' => $WAITER->id,
                'date' => Carbon::now()->toDateString(),
                'paid' => false,
                'total' => 200
            ];
            $order = Order::create($payload);
    
            $response = $this->postJson('/api/checkout', [
                'order_id' => $order->id,
                'checkout_type' => OrderStrategiesEnum::SERVICES_ONLY
            ]);
            $response->assertStatus(200);
            $responseData = $response->json();
            $expectedSubTotal = 200;
            $expectedTotal = 200  * (1 + 0.15);
            $this->assertEquals($expectedSubTotal, $responseData['invoice']['sub_total']);
            $this->assertEquals($expectedTotal, $responseData['invoice']['total']);
        }
}
