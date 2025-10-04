<?php

use App\Http\Controllers\GoogleIntegrationController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlanItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeSearchController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard if authenticated, otherwise to login
Route::get('/', function () {
    return auth()->check() 
        ? redirect()->route('dashboard') 
        : redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ingredients Routes
    Route::resource('ingredients', IngredientController::class);

    // Recipes Routes
    Route::get('/recipes/search', [RecipeSearchController::class, 'search'])->name('recipes.search');
    Route::resource('recipes', RecipeController::class);

    // Plans Routes
    Route::get('/plans/{plan}/shopping-list', [PlanController::class, 'shoppingList'])->name('plans.shopping-list');
    Route::get('/plans/{plan}/download-shopping-list', [PlanController::class, 'downloadShoppingList'])->name('plans.download-shopping-list');
    Route::resource('plans', PlanController::class);

    // Plan Items Routes
    Route::post('/plan-items', [PlanItemController::class, 'store'])->name('plan-items.store');
    Route::put('/plan-items/{planItem}', [PlanItemController::class, 'update'])->name('plan-items.update');
    Route::delete('/plan-items/{planItem}', [PlanItemController::class, 'destroy'])->name('plan-items.destroy');

    // Google Calendar Integration (opcional)
    Route::get('/google/redirect', [GoogleIntegrationController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/google/callback', [GoogleIntegrationController::class, 'handleCallback'])->name('google.callback');
    Route::post('/plans/{plan}/export', [GoogleIntegrationController::class, 'exportPlanToCalendar'])->name('plans.export');
});

require __DIR__.'/auth.php';
