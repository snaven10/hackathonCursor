<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    Mis Recetas
                </h2>
                <p class="text-sm text-gray-600 mt-1">Gestiona y organiza tus recetas favoritas</p>
            </div>
            <a href="{{ route('recipes.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <span class="mr-2">+</span> Nueva Receta
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($recipes as $recipe)
                <div class="group">
                    <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                        <!-- Decorative gradient -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-bl-full transform group-hover:scale-110 transition-transform duration-300"></div>
                        
                        <div class="p-6 relative">
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                    {{ $recipe->title }}
                                </h3>
                                
                                @if($recipe->description)
                                    <p class="text-gray-600 text-sm line-clamp-2">{{ $recipe->description }}</p>
                                @endif
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-orange-100 to-red-100 text-orange-700 rounded-full text-sm font-semibold">
                                        🔥 {{ number_format($recipe->total_calories ?? 0, 0) }} kcal
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 rounded-full text-sm font-semibold">
                                        🍽️ {{ $recipe->servings }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 rounded-full text-sm font-semibold">
                                        🥗 {{ $recipe->ingredients->count() }} ingredientes
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex gap-2">
                                <a href="{{ route('recipes.show', $recipe) }}" class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                    Ver Receta
                                </a>
                                <a href="{{ route('recipes.edit', $recipe) }}" class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                                    Editar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3">
                    <div class="text-center py-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-dashed border-gray-300">
                        <div class="text-6xl mb-4">📖</div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">No hay recetas aún</h3>
                        <p class="text-gray-500 mb-6">Comienza creando tu primera receta</p>
                        <a href="{{ route('recipes.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="mr-2">+</span> Crear Primera Receta
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($recipes->hasPages())
            <div class="mt-6">
                {{ $recipes->links() }}
            </div>
        @endif
    </div>
</x-app-layout>

