<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function __construct(
        private RecipeService $recipeService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $recipes = Recipe::with('ingredients')
            ->latest()
            ->paginate(12);
        
        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $ingredients = Ingredient::orderBy('name')->get();
        
        return view('recipes.form', [
            'recipe' => new Recipe(),
            'ingredients' => $ingredients,
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request): RedirectResponse
    {
        $recipe = Recipe::create($request->validated());
        
        $this->recipeService->syncIngredients($recipe, $request->input('ingredients'));
        
        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', 'Receta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe): View
    {
        $recipe->load('ingredients');
        
        $nutrition = $this->recipeService->calculateNutrition($recipe);
        
        return view('recipes.show', compact('recipe', 'nutrition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe): View
    {
        $recipe->load('ingredients');
        $ingredients = Ingredient::orderBy('name')->get();
        
        return view('recipes.form', [
            'recipe' => $recipe,
            'ingredients' => $ingredients,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe): RedirectResponse
    {
        $recipe->update($request->validated());
        
        $this->recipeService->syncIngredients($recipe, $request->input('ingredients'));
        
        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', 'Receta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        $recipe->delete();
        
        return redirect()
            ->route('recipes.index')
            ->with('success', 'Receta eliminada exitosamente.');
    }
}
