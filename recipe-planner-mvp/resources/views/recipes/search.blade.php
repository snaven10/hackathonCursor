<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Buscar Recetas por Ingredientes
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Form -->
        <x-card class="mb-6">
            <form action="{{ route('recipes.search') }}" method="GET">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Selecciona los ingredientes que tienes disponibles
                        </label>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @foreach($ingredients as $ingredient)
                                <label class="flex items-center space-x-2 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer transition">
                                    <input 
                                        type="checkbox" 
                                        name="ingredients[]" 
                                        value="{{ $ingredient->id }}"
                                        {{ in_array($ingredient->id, $selectedIngredients) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    >
                                    <span class="text-sm text-gray-700">{{ $ingredient->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <x-button type="submit">
                            Buscar Recetas
                        </x-button>
                    </div>
                </div>
            </form>
        </x-card>

        <!-- Results -->
        @if(count($selectedIngredients) > 0)
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    Resultados: {{ $recipes->count() }} {{ $recipes->count() === 1 ? 'receta encontrada' : 'recetas encontradas' }}
                </h3>
            </div>

            @if($recipes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recipes as $recipe)
                        <x-card class="hover:shadow-xl transition-shadow">
                            <div class="space-y-3">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $recipe->title }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $recipe->match_count }} {{ $recipe->match_count === 1 ? 'coincidencia' : 'coincidencias' }}
                                    </span>
                                </div>
                                
                                @if($recipe->description)
                                    <p class="text-gray-600 text-sm line-clamp-2">{{ $recipe->description }}</p>
                                @endif
                                
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>🔥 {{ number_format($recipe->total_calories ?? 0, 0) }} kcal</span>
                                    <span>🍽️ {{ $recipe->servings }} {{ $recipe->servings > 1 ? 'porciones' : 'porción' }}</span>
                                </div>

                                <!-- Matching Ingredients -->
                                <div class="pt-3 border-t">
                                    <p class="text-xs text-gray-500 mb-2">Ingredientes que coinciden:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($recipe->ingredients->whereIn('id', $selectedIngredients) as $ingredient)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $ingredient->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Missing Ingredients -->
                                @php
                                    $missingIngredients = $recipe->ingredients->whereNotIn('id', $selectedIngredients);
                                @endphp
                                
                                @if($missingIngredients->count() > 0)
                                    <div class="pt-2">
                                        <p class="text-xs text-gray-500 mb-2">Te faltan:</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($missingIngredients as $ingredient)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-700">
                                                    {{ $ingredient->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="pt-3">
                                    <x-button :href="route('recipes.show', $recipe)" type="primary" class="w-full justify-center">
                                        Ver Receta Completa
                                    </x-button>
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 mb-4">No se encontraron recetas con los ingredientes seleccionados.</p>
                    <p class="text-gray-400 text-sm">Intenta seleccionar menos ingredientes o crea una nueva receta.</p>
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">🔍</div>
                <p class="text-gray-500 mb-2">Selecciona los ingredientes que tienes disponibles</p>
                <p class="text-gray-400 text-sm">Te mostraremos las recetas que puedes preparar</p>
            </div>
        @endif
    </div>
</x-app-layout>

