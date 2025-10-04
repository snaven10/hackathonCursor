<?php

namespace App\Services;

use App\Models\Recipe;

class RecipeService
{
    /**
     * Calculate nutritional values for a recipe.
     *
     * @param Recipe $recipe
     * @return array<string, float>
     */
    public function calculateNutrition(Recipe $recipe): array
    {
        $totalCalories = 0;
        $totalProteins = 0;
        $totalFats = 0;
        $totalCarbs = 0;

        foreach ($recipe->ingredients as $ingredient) {
            $quantity = $ingredient->pivot->quantity;
            
            $totalCalories += $ingredient->calories_per_unit * $quantity;
            $totalProteins += $ingredient->protein_per_unit * $quantity;
            $totalFats += $ingredient->fat_per_unit * $quantity;
            $totalCarbs += $ingredient->carbs_per_unit * $quantity;
        }

        return [
            'calories' => round($totalCalories, 2),
            'proteins' => round($totalProteins, 2),
            'fats' => round($totalFats, 2),
            'carbs' => round($totalCarbs, 2),
        ];
    }

    /**
     * Update recipe nutrition values in database.
     *
     * @param Recipe $recipe
     * @return void
     */
    public function updateRecipeNutrition(Recipe $recipe): void
    {
        $nutrition = $this->calculateNutrition($recipe);
        
        $recipe->update([
            'total_calories' => $nutrition['calories'],
        ]);
    }

    /**
     * Sync recipe ingredients and update nutrition.
     *
     * @param Recipe $recipe
     * @param array<int, array{id: int, quantity: float, unit: string|null}> $ingredients
     * @return void
     */
    public function syncIngredients(Recipe $recipe, array $ingredients): void
    {
        $syncData = [];
        
        foreach ($ingredients as $ingredient) {
            $syncData[$ingredient['id']] = [
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'] ?? null,
            ];
        }
        
        $recipe->ingredients()->sync($syncData);
        
        // Recalculate nutrition after syncing
        $this->updateRecipeNutrition($recipe);
    }
}

