<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class RecipeSearchController extends Controller
{
    /**
     * Search recipes by ingredients.
     */
    public function search(Request $request): View
    {
        $request->validate([
            'ingredients' => ['nullable', 'array'],
            'ingredients.*' => ['exists:ingredients,id'],
        ]);

        $ingredients = Ingredient::orderBy('name')->get();
        $selectedIngredients = $request->input('ingredients', []);
        
        $recipes = collect();
        
        if (!empty($selectedIngredients)) {
            // Generate cache key based on selected ingredients
            $sortedIngredients = $selectedIngredients;
            sort($sortedIngredients);
            $cacheKey = 'recipe_search_' . md5(implode(',', $sortedIngredients));
            
            // Cache results for 1 hour
            $recipes = Cache::remember($cacheKey, 3600, function () use ($selectedIngredients) {
                return Recipe::with('ingredients')
                    ->whereHas('ingredients', function ($query) use ($selectedIngredients) {
                        $query->whereIn('ingredient_id', $selectedIngredients);
                    })
                    ->get()
                    ->map(function ($recipe) use ($selectedIngredients) {
                        // Count how many matching ingredients this recipe has
                        $matchCount = $recipe->ingredients
                            ->whereIn('id', $selectedIngredients)
                            ->count();
                        
                        $recipe->match_count = $matchCount;
                        return $recipe;
                    })
                    // Sort by most matching ingredients first
                    ->sortByDesc('match_count')
                    ->values();
            });
        }
        
        return view('recipes.search', compact('ingredients', 'selectedIngredients', 'recipes'));
    }
}
