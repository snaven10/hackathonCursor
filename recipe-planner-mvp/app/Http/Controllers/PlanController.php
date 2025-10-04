<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Recipe;
use App\Services\ShoppingListService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function __construct(
        private ShoppingListService $shoppingListService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $plans = auth()->user()
            ->plans()
            ->latest()
            ->paginate(10);
        
        return view('plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('plans.form', [
            'plan' => new Plan(),
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'meals_per_day' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $plan = auth()->user()->plans()->create($validated);
        
        return redirect()
            ->route('plans.show', $plan)
            ->with('success', 'Plan creado exitosamente. Ahora puedes agregar recetas.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan): View
    {
        // Verificar que el plan pertenece al usuario autenticado
        if ($plan->user_id !== auth()->id()) {
            abort(403);
        }
        
        $plan->load('planItems.recipe.ingredients');
        
        // Obtener todas las recetas para el selector
        $recipes = Recipe::with('ingredients')->orderBy('title')->get();
        
        // Calcular calorías por día
        $caloriesPerDay = $plan->getCaloriesPerDay();
        
        return view('plans.show', compact('plan', 'recipes', 'caloriesPerDay'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan): View
    {
        if ($plan->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('plans.form', [
            'plan' => $plan,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan): RedirectResponse
    {
        if ($plan->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'meals_per_day' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $plan->update($validated);
        
        return redirect()
            ->route('plans.show', $plan)
            ->with('success', 'Plan actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan): RedirectResponse
    {
        if ($plan->user_id !== auth()->id()) {
            abort(403);
        }
        
        $plan->delete();
        
        return redirect()
            ->route('plans.index')
            ->with('success', 'Plan eliminado exitosamente.');
    }

    /**
     * Generate and display shopping list for a plan.
     */
    public function shoppingList(Plan $plan): View
    {
        if ($plan->user_id !== auth()->id()) {
            abort(403);
        }
        
        $shoppingList = $this->shoppingListService->generateFromPlan($plan);
        
        return view('plans.shopping-list', compact('plan', 'shoppingList'));
    }

    /**
     * Download shopping list as CSV.
     */
    public function downloadShoppingList(Plan $plan): Response
    {
        if ($plan->user_id !== auth()->id()) {
            abort(403);
        }
        
        $shoppingList = $this->shoppingListService->generateFromPlan($plan);
        $csv = $this->shoppingListService->exportToCSV($shoppingList);
        
        $filename = 'lista-compras-' . $plan->start_date->format('Y-m-d') . '.csv';
        
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
