<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PizzaUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected $ingredient1;
    protected $ingredient2;

    public function setUp(): void
    {
        parent::setUp();

        $this->ingredient1 = Ingredient::create(['name' => 'Tomato', 'cost_price' => 1.00]);
        $this->ingredient2 = Ingredient::create(['name' => 'Cheese', 'cost_price' => 1.50]);
    }

    /** test pizza update*/
    public function shouldSuccessfulUpdatePizza()
    {

        $pizza = new Pizza();
        $pizza->selling_price = 5.99;
        $pizza->save();
        $pizza->ingredients()->sync([$this->ingredient1->id]);

        $updateData = [
            'selling_price' => 10.99,
            'ingredients' => [$this->ingredient1->id, $this->ingredient2->id]
        ];

        $response = $this->putJson("/api/pizzas/{$pizza->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Pizza updated successfully!']);

        $this->assertDatabaseHas('pizzas', [
            'id' => $pizza->id,
            'selling_price' => $updateData['selling_price'],
        ]);

        $this->assertEquals(2, $pizza->fresh()->ingredients->count());
    }

    /** test fail non existin pizza update*/
    public function testUpdateNonExistentPizza()
    {
        $response = $this->putJson('/api/pizzas/99999', [
            'selling_price' => '4.99',
            'ingredients' => [$this->ingredient1->id]
        ]);

        $response->assertStatus(404);
    }
}
