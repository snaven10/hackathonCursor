<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ $recipe->title }}
            </h2>
            <div class="flex space-x-2">
                <x-button type="secondary" :href="route('recipes.index')">
                    Volver
                </x-button>
                <x-button :href="route('recipes.edit', $recipe)">
                    Editar
                </x-button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                @if($recipe->description)
                    <x-card title="Descripción">
                        <p class="text-gray-700">{{ $recipe->description }}</p>
                    </x-card>
                @endif

                <!-- Instructions -->
                <x-card title="Instrucciones">
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($recipe->instructions)) !!}
                    </div>
                </x-card>

                <!-- Ingredients -->
                <x-card title="Ingredientes">
                    <ul class="space-y-3">
                        @foreach($recipe->ingredients as $ingredient)
                            <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <span class="font-medium text-gray-900">{{ $ingredient->name }}</span>
                                    <span class="text-gray-600 text-sm ml-2">
                                        ({{ number_format($ingredient->pivot->quantity, 2) }} {{ $ingredient->pivot->unit ?? $ingredient->unit }})
                                    </span>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ number_format($ingredient->calories_per_unit * $ingredient->pivot->quantity, 0) }} kcal
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </x-card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Nutrition Info -->
                <x-card title="Información Nutricional">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total</span>
                            <span class="text-2xl font-bold text-indigo-600">{{ number_format($nutrition['calories'], 0) }} kcal</span>
                        </div>
                        
                        <div class="border-t pt-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Proteínas</span>
                                <span class="font-semibold text-gray-900">{{ number_format($nutrition['proteins'], 1) }}g</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Grasas</span>
                                <span class="font-semibold text-gray-900">{{ number_format($nutrition['fats'], 1) }}g</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Carbohidratos</span>
                                <span class="font-semibold text-gray-900">{{ number_format($nutrition['carbs'], 1) }}g</span>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Porciones</span>
                                <span class="font-semibold text-gray-900">{{ $recipe->servings }}</span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-sm text-gray-500">Por porción</span>
                                <span class="text-sm font-semibold text-gray-700">{{ number_format($nutrition['calories'] / $recipe->servings, 0) }} kcal</span>
                            </div>
                        </div>
                    </div>
                </x-card>

                <!-- Actions -->
                <x-card title="Acciones">
                    <div class="space-y-3">
                        <x-button :href="route('recipes.edit', $recipe)" class="w-full justify-center">
                            Editar Receta
                        </x-button>
                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta receta?');">
                            @csrf
                            @method('DELETE')
                            <x-button type="danger" type="submit" class="w-full justify-center">
                                Eliminar Receta
                            </x-button>
                        </form>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>

