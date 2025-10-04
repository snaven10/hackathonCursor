<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PlanItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'day_of_week' => ['required', 'integer', 'min:1', 'max:7'],
            'meal_order' => ['required', 'integer', 'min:1', 'max:3'],
            'recipe_id' => ['required', 'exists:recipes,id'],
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);
        
        // Verificar que el plan pertenece al usuario
        if ($plan->user_id !== auth()->id()) {
            abort(403);
        }

        PlanItem::create($validated);
        
        return redirect()
            ->route('plans.show', $plan)
            ->with('success', 'Receta agregada al plan exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlanItem $planItem): RedirectResponse
    {
        // Verificar que el plan pertenece al usuario
        if ($planItem->plan->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'recipe_id' => ['required', 'exists:recipes,id'],
        ]);

        $planItem->update($validated);
        
        return redirect()
            ->route('plans.show', $planItem->plan)
            ->with('success', 'Receta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanItem $planItem): RedirectResponse
    {
        // Verificar que el plan pertenece al usuario
        if ($planItem->plan->user_id !== auth()->id()) {
            abort(403);
        }
        
        $plan = $planItem->plan;
        $planItem->delete();
        
        return redirect()
            ->route('plans.show', $plan)
            ->with('success', 'Receta eliminada del plan.');
    }
}
