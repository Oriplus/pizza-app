<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePizzaRequest;
use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
