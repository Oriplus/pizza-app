<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePizzaRequest;
use App\Http\Requests\UpdatePizzaRequest;
use App\Models\Ingredient;
use App\Models\Pizza;

class PizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = Ingredient::all();
        $pizzas = Pizza::with('ingredients')->get();
        return response()->json(['ingredients' => $ingredients, 'pizzas' => $pizzas], 200);
    }

    /**
     * Store a newly created pizza in storage.
     * @param  App\Http\Requests\StorePizzaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePizzaRequest $request)
    {
        try {
            $pizza = Pizza::create([
                'name' => $request->name,
                'selling_price' => $request->selling_price,
            ]);
            $pizza->ingredients()->sync($request->ingredients);
            $pizzas = Pizza::with('ingredients')->get();
            return response()->json(['message' => 'Pizza created successfully!', 'pizzas' => $pizzas], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create pizza', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update a pizza.
     * @param  App\Http\Requests\UpdatePizzaRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePizzaRequest $request, string $id)
    {
        $pizza = Pizza::findOrFail($id);
        try {
            $pizza->update([
                'selling_price' => $request->selling_price,
            ]);
            $pizza->ingredients()->sync($request->ingredients);
            $pizzas = Pizza::with('ingredients')->get();
            return response()->json(['message' => 'Pizza updated successfully!', 'pizzas' => $pizzas], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed updating pizza', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * delete a pizza.
     * @param string $id
     * @return void
     */
    public function destroy(string $id)
    {
        $pizza = Pizza::findOrFail($id);
        try {
            $pizza->delete();
            $pizzas = Pizza::with('ingredients')->get();
            return response()->json(['message' => 'Pizza deleted successfully!', 'pizzas' => $pizzas], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed deleting pizza', 'error' => $e->getMessage()], 500);
        }
    }
}
