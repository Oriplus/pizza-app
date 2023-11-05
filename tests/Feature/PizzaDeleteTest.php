<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PizzaDeleteTest extends TestCase
{
    /** Test delete a pizza */
    public function test_a_pizza_can_be_deleted()
    {
        $pizza = Pizza::create(['name' => 'Simple Pizza', 'selling_price' => 9.99]);
        $ingredient = Ingredient::create(['name' => 'Tomato', 'cost_price' => 1.00]);
        $pizza->ingredients()->sync($ingredient);

        $response = $this->deleteJson("/api/pizzas/{$pizza->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Pizza deleted successfully!',
                 ]);
        $this->assertDatabaseMissing('pizzas', ['id' => $pizza->id]);
    }

    /** @test fail delete a non existing pizza */
    public function test_fail_non_existing_pizza()
    {
        $response = $this->deleteJson("/api/pizzas/99999");

        $response->assertStatus(404);
    }
}
