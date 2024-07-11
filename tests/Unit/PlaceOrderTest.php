<?php

namespace Tests\Unit;

use App\Enums\UserRoleEnum;
use App\Models\Customer;
use App\Models\Meal;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Spatie\LaravelIgnition\FlareMiddleware\AddJobs;

class PlaceOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_authenticated_endpoint_place_order()
    {
        $response = $this->postJson('/api/place-order', []);
        $response->assertStatus(401);
    }

    /** @test */
    public function test_authorization_endpoint_place_order()
    {
        $customerUser = User::factory()->create();
        Passport::actingAs($customerUser);
        $response = $this->postJson('/api/place-order', []);
        $response->assertStatus(403);
    }


    /** @test */
    public function it_place_order_tables()
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
        $meal1 = Meal::factory()->create(['price' => 100]);
        $meal2 = Meal::factory()->create(['price' => 200]);

        $payload = [
            'table_id' => $table->id,
            'reservation_id' => $reservation->id,
            'customer_id' => $customer->id,
            'date' => Carbon::now()->toDateString(),
            'paid' => false,
            'meals' => [
                ['meal_id' => $meal1->id],
                ['meal_id' => $meal2->id]
            ]
        ];

        $response = $this->postJson('/api/place-order', $payload);

        $response->assertStatus(200);
    }
}
