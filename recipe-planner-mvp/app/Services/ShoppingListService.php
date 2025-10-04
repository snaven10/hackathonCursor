<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Collection;

class ShoppingListService
{
    /**
     * Generate shopping list from a plan.
     *
     * @param Plan $plan
     * @return Collection
     */
    public function generateFromPlan(Plan $plan): Collection
    {
        $plan->load('planItems.recipe.ingredients');
        
        $ingredientsList = [];
        
        foreach ($plan->planItems as $planItem) {
            if (!$planItem->recipe) {
                continue;
            }
            
            foreach ($planItem->recipe->ingredients as $ingredient) {
                $key = $ingredient->id;
                $quantity = $ingredient->pivot->quantity;
                $unit = $ingredient->pivot->unit ?? $ingredient->unit;
                
                if (!isset($ingredientsList[$key])) {
                    $ingredientsList[$key] = [
                        'id' => $ingredient->id,
                        'name' => $ingredient->name,
                        'unit' => $unit,
                        'quantity' => 0,
                    ];
                }
                
                // Sumar cantidades (solo si la unidad coincide)
                if ($ingredientsList[$key]['unit'] === $unit) {
                    $ingredientsList[$key]['quantity'] += $quantity;
                } else {
                    // Si las unidades no coinciden, crear entrada separada
                    $altKey = $key . '_' . $unit;
                    if (!isset($ingredientsList[$altKey])) {
                        $ingredientsList[$altKey] = [
                            'id' => $ingredient->id,
                            'name' => $ingredient->name,
                            'unit' => $unit,
                            'quantity' => $quantity,
                        ];
                    } else {
                        $ingredientsList[$altKey]['quantity'] += $quantity;
                    }
                }
            }
        }
        
        return collect($ingredientsList)
            ->sortBy('name')
            ->values();
    }
    
    /**
     * Export shopping list to CSV format.
     *
     * @param Collection $shoppingList
     * @return string
     */
    public function exportToCSV(Collection $shoppingList): string
    {
        $csv = "Ingrediente,Cantidad,Unidad\n";
        
        foreach ($shoppingList as $item) {
            $csv .= sprintf(
                '"%s",%.2f,"%s"' . "\n",
                $item['name'],
                $item['quantity'],
                $item['unit']
            );
        }
        
        return $csv;
    }
}

