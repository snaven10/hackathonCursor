<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-emerald-600">
                Dashboard
            </h2>
            <span class="text-sm text-gray-500">Bienvenido, {{ Auth::user()->name }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards con gradientes modernos -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Recetas Card -->
                <div class="group bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-t-4 border-emerald-500">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Recetas</p>
                            <p class="text-4xl font-bold text-emerald-600">
                                {{ \App\Models\Recipe::count() }}
                            </p>
                        </div>
                        <div class="bg-emerald-100 rounded-xl p-4">
                            <span class="text-4xl">📖</span>
                        </div>
                    </div>
                    <x-button :href="route('recipes.index')" class="w-full justify-center">
                        Ver Recetas
                    </x-button>
                </div>

                <!-- Ingredientes Card -->
                <div class="group bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-t-4 border-teal-500">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Ingredientes</p>
                            <p class="text-4xl font-bold text-teal-600">
                                {{ \App\Models\Ingredient::count() }}
                            </p>
                        </div>
                        <div class="bg-teal-100 rounded-xl p-4">
                            <span class="text-4xl">🥗</span>
                        </div>
                    </div>
                    <x-button :href="route('ingredients.index')" variant="secondary" class="w-full justify-center">
                        Ver Ingredientes
                    </x-button>
                </div>

                <!-- Buscar Card -->
                <div class="group bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-t-4 border-amber-500">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Buscar Recetas</p>
                            <p class="text-lg font-semibold text-amber-600">
                                Por ingredientes
                            </p>
                        </div>
                        <div class="bg-amber-100 rounded-xl p-4">
                            <span class="text-4xl">🔍</span>
                        </div>
                    </div>
                    <x-button :href="route('recipes.search')" variant="outline" class="w-full justify-center">
                        Buscar Ahora
                    </x-button>
                </div>
            </div>

            <!-- Welcome Message con diseño limpio -->
            <div class="bg-white rounded-2xl shadow-md p-8 border-l-4 border-emerald-500">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">¡Hola, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-gray-600">
                            Gestiona tus recetas e ingredientes de forma inteligente
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <img src="{{ asset('logo.png') }}" alt="Recipe Planner" width="52" height="52" class="rounded-lg shadow-md">
                    </div>
                </div>
                
                <div class="mt-6 flex flex-wrap gap-3">
                    <x-button :href="route('recipes.create')">
                        <span class="mr-2">+</span> Nueva Receta
                    </x-button>
                    <x-button :href="route('ingredients.create')" variant="outline">
                        <span class="mr-2">+</span> Nuevo Ingrediente
                    </x-button>
                </div>
            </div>

            <!-- Recent Recipes con diseño moderno -->
            @php
                $recentRecipes = \App\Models\Recipe::with('ingredients')->latest()->take(3)->get();
            @endphp

            @if($recentRecipes->count() > 0)
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">
                            Recetas Recientes
                        </h3>
                        <a href="{{ route('recipes.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium text-sm">
                            Ver todas →
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($recentRecipes as $recipe)
                            <a href="{{ route('recipes.show', $recipe) }}" class="group block">
                                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-t-2 border-emerald-500">
                                    <div class="p-6">
                                        <h4 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                                            {{ $recipe->title }}
                                        </h4>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="inline-flex items-center px-3 py-1.5 bg-orange-100 text-orange-700 rounded-full font-medium">
                                                🔥 {{ number_format($recipe->total_calories ?? 0, 0) }} kcal
                                            </span>
                                            <span class="inline-flex items-center px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-full font-medium">
                                                🥗 {{ $recipe->ingredients->count() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
