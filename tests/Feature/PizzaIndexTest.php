<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PizzaIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test index test */
    public function test_returns_all_pizzas_and_ingredients()
    {
        $ingredient1 = Ingredient::create(['name' => 'Tomato', 'cost_price' => 1.00]);
        $ingredient2 = Ingredient::create(['name' => 'Cheese', 'cost_price' => 1.50]);

        $pizza1 = Pizza::create(['name' => 'New Pizza', 'selling_price' => 10.00]);
        $pizza1->ingredients()->sync([$ingredient1->id, $ingredient2->id]);

        $response = $this->getJson('/api/pizzas');

        $response->assertStatus(200)
            ->assertJson([
                'ingredients' => true,
                'pizzas' => true,
            ])
            ->assertJsonCount(1, 'pizzas')
            ->assertJsonCount(2, 'ingredients');
    }
}
