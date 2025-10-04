<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
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
                <div class="group relative bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-1 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="bg-white rounded-xl p-6 h-full">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Recetas</p>
                                <p class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                    {{ \App\Models\Recipe::count() }}
                                </p>
                            </div>
                            <div class="bg-gradient-to-br from-indigo-100 to-purple-100 rounded-xl p-4">
                                <span class="text-4xl">📖</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-button :href="route('recipes.index')" class="w-full justify-center bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600">
                                Ver Recetas
                            </x-button>
                        </div>
                    </div>
                </div>

                <!-- Ingredientes Card -->
                <div class="group relative bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 rounded-2xl p-1 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="bg-white rounded-xl p-6 h-full">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Ingredientes</p>
                                <p class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                    {{ \App\Models\Ingredient::count() }}
                                </p>
                            </div>
                            <div class="bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl p-4">
                                <span class="text-4xl">🥗</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-button :href="route('ingredients.index')" class="w-full justify-center bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600">
                                Ver Ingredientes
                            </x-button>
                        </div>
                    </div>
                </div>

                <!-- Buscar Card -->
                <div class="group relative bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 rounded-2xl p-1 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="bg-white rounded-xl p-6 h-full">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Buscar Recetas</p>
                                <p class="text-lg font-semibold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                    Por ingredientes
                                </p>
                            </div>
                            <div class="bg-gradient-to-br from-amber-100 to-orange-100 rounded-xl p-4">
                                <span class="text-4xl">🔍</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-button :href="route('recipes.search')" class="w-full justify-center bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600">
                                Buscar Ahora
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Message con diseño moderno -->
            <div class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl shadow-2xl overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="relative p-8 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold mb-2">¡Hola, {{ Auth::user()->name }}! 👋</h3>
                            <p class="text-indigo-100">
                                Gestiona tus recetas e ingredientes de forma inteligente
                            </p>
                        </div>
                        <div class="hidden md:block">
                            <img src="{{ asset('logo.png') }}" alt="Recipe Planner" width="52" height="52" class="rounded-lg shadow-xl opacity-90">
                        </div>
                    </div>
                    
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('recipes.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="mr-2">+</span> Nueva Receta
                        </a>
                        <a href="{{ route('ingredients.create') }}" class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white rounded-xl font-semibold hover:bg-white/30 transition-all duration-200">
                            <span class="mr-2">+</span> Nuevo Ingrediente
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Recipes con diseño moderno -->
            @php
                $recentRecipes = \App\Models\Recipe::with('ingredients')->latest()->take(3)->get();
            @endphp

            @if($recentRecipes->count() > 0)
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                            Recetas Recientes
                        </h3>
                        <a href="{{ route('recipes.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                            Ver todas →
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($recentRecipes as $recipe)
                            <a href="{{ route('recipes.show', $recipe) }}" class="group block">
                                <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-bl-full"></div>
                                    <div class="p-6 relative">
                                        <h4 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                            {{ $recipe->title }}
                                        </h4>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-700 rounded-full font-medium">
                                                🔥 {{ number_format($recipe->total_calories ?? 0, 0) }} kcal
                                            </span>
                                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full font-medium">
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
