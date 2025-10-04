<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeSearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

// Ingredients Routes
Route::resource('ingredients', IngredientController::class);

// Recipes Routes
Route::get('/recipes/search', [RecipeSearchController::class, 'search'])->name('recipes.search');
Route::resource('recipes', RecipeController::class);
