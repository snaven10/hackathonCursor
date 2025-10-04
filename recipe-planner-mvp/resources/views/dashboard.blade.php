<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Recetas Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <span class="text-3xl">📖</span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Recetas
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900">
                                        {{ \App\Models\Recipe::count() }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-button :href="route('recipes.index')" class="w-full justify-center">
                                Ver Recetas
                            </x-button>
                        </div>
                    </div>
                </div>

                <!-- Ingredientes Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <span class="text-3xl">🥗</span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Ingredientes
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900">
                                        {{ \App\Models\Ingredient::count() }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-button :href="route('ingredients.index')" class="w-full justify-center">
                                Ver Ingredientes
                            </x-button>
                        </div>
                    </div>
                </div>

                <!-- Buscar Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <span class="text-3xl">🔍</span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Buscar Recetas
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        Por ingredientes
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-button :href="route('recipes.search')" class="w-full justify-center">
                                Buscar Ahora
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">¡Bienvenido, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-600">
                        Estás usando Recipe Planner MVP. Aquí puedes gestionar tus recetas, ingredientes y buscar recetas según los ingredientes que tengas disponibles.
                    </p>
                    
                    <div class="mt-4 flex space-x-3">
                        <x-button :href="route('recipes.create')">
                            + Nueva Receta
                        </x-button>
                        <x-button type="secondary" :href="route('ingredients.create')">
                            + Nuevo Ingrediente
                        </x-button>
                    </div>
                </div>
            </div>

            <!-- Recent Recipes -->
            @php
                $recentRecipes = \App\Models\Recipe::with('ingredients')->latest()->take(3)->get();
            @endphp

            @if($recentRecipes->count() > 0)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recetas Recientes</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($recentRecipes as $recipe)
                            <x-card>
                                <a href="{{ route('recipes.show', $recipe) }}" class="block">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-2">{{ $recipe->title }}</h4>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>🔥 {{ number_format($recipe->total_calories ?? 0, 0) }} kcal</span>
                                        <span>🥗 {{ $recipe->ingredients->count() }} ing.</span>
                                    </div>
                                </a>
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
