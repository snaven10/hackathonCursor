<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Recetas
            </h2>
            <x-button :href="route('recipes.create')">
                + Nueva Receta
            </x-button>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($recipes as $recipe)
                <x-card class="cursor-pointer hover:scale-105 transition-transform duration-200">
                    <a href="{{ route('recipes.show', $recipe) }}" class="block">
                        <div class="space-y-3">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $recipe->title }}</h3>
                            
                            @if($recipe->description)
                                <p class="text-gray-600 text-sm line-clamp-2">{{ $recipe->description }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>🔥 {{ number_format($recipe->total_calories ?? 0, 0) }} kcal</span>
                                <span>🍽️ {{ $recipe->servings }} {{ $recipe->servings > 1 ? 'porciones' : 'porción' }}</span>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-500">
                                <span>🥗 {{ $recipe->ingredients->count() }} ingredientes</span>
                            </div>
                            
                            <div class="flex justify-between items-center pt-2">
                                <x-button :href="route('recipes.show', $recipe)" type="primary">
                                    Ver Receta
                                </x-button>
                                <div class="flex space-x-2">
                                    <a href="{{ route('recipes.edit', $recipe) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                        Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </a>
                </x-card>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 mb-4">No hay recetas registradas.</p>
                    <x-button :href="route('recipes.create')">
                        Crear Primera Receta
                    </x-button>
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

