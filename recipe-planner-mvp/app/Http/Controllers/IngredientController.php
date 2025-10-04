<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Ingredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $ingredients = Ingredient::latest()->paginate(15);
        
        return view('ingredients.index', compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('ingredients.form', [
            'ingredient' => new Ingredient(),
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIngredientRequest $request): RedirectResponse
    {
        Ingredient::create($request->validated());
        
        return redirect()
            ->route('ingredients.index')
            ->with('success', 'Ingrediente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient): View
    {
        return view('ingredients.show', compact('ingredient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingredient $ingredient): View
    {
        return view('ingredients.form', [
            'ingredient' => $ingredient,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient): RedirectResponse
    {
        $ingredient->update($request->validated());
        
        return redirect()
            ->route('ingredients.index')
            ->with('success', 'Ingrediente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient): RedirectResponse
    {
        $ingredient->delete();
        
        return redirect()
            ->route('ingredients.index')
            ->with('success', 'Ingrediente eliminado exitosamente.');
    }
}
