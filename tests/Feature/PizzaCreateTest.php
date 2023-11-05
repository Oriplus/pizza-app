<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PizzaCreateTest extends TestCase
{

    use RefreshDatabase;

    /** @test create a pizza*/
    public function test_create_pizza(): void
    {
        $ingredient1 = Ingredient::create(['name' => 'Cheese', 'cost_price' => 1.00]);
        $ingredient2 = Ingredient::create(['name' => 'Tomato', 'cost_price' => 0.50]);

        $response = $this->postJson('/api/pizzas', [
            'name' => 'Test Pizza',
            'selling_price' => 9.99,
            'ingredients' => [$ingredient1->id, $ingredient2->id]
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Pizza created successfully!',
            ]);

        $this->assertDatabaseHas('pizzas', [
            'name' => 'Test Pizza',
            'selling_price' => 9.99,
        ]);
    }

    /** @test create pizza validations */
    public function test_fail_pizza_create(): void
    {
        $response = $this->postJson('/api/pizzas', [
            'name' => '',
            'selling_price' => 'price',
            'ingredients' => 'ingredient',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'selling_price', 'ingredients']);
    }
}
