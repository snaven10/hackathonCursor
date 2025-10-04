<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $isEdit ? 'Editar Receta' : 'Nueva Receta' }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ $isEdit ? route('recipes.update', $recipe) : route('recipes.store') }}" method="POST" x-data="{
                ingredients: @json($isEdit ? $recipe->ingredients->map(function($ing) {
                    return [
                        'id' => $ing->id,
                        'quantity' => $ing->pivot->quantity,
                        'unit' => $ing->pivot->unit
                    ];
                })->values() : []),
                
                init() {
                    if (this.ingredients.length === 0) {
                        this.addIngredient();
                    }
                },
                
                addIngredient() {
                    this.ingredients.push({
                        id: '',
                        quantity: '',
                        unit: ''
                    });
                },
                
                removeIngredient(index) {
                    this.ingredients.splice(index, 1);
                }
            }">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Título de la Receta <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            value="{{ old('title', $recipe->title) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                            required
                        >
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción
                        </label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror"
                        >{{ old('description', $recipe->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instructions -->
                    <div>
                        <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">
                            Instrucciones <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="instructions" 
                            id="instructions" 
                            rows="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('instructions') border-red-500 @enderror"
                            required
                        >{{ old('instructions', $recipe->instructions) }}</textarea>
                        @error('instructions')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Servings -->
                    <div>
                        <label for="servings" class="block text-sm font-medium text-gray-700 mb-2">
                            Número de Porciones <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="servings" 
                            id="servings" 
                            value="{{ old('servings', $recipe->servings ?? 1) }}"
                            min="1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('servings') border-red-500 @enderror"
                            required
                        >
                        @error('servings')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ingredients -->
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <label class="block text-sm font-medium text-gray-700">
                                Ingredientes <span class="text-red-500">*</span>
                            </label>
                            <button type="button" @click="addIngredient()" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                + Agregar Ingrediente
                            </button>
                        </div>

                        @error('ingredients')
                            <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                        @enderror

                        <div class="space-y-3">
                            <template x-for="(ingredient, index) in ingredients" :key="index">
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                    <!-- Ingredient Select -->
                                    <div class="flex-1">
                                        <select 
                                            :name="'ingredients[' + index + '][id]'" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500"
                                            required
                                        >
                                            <option value="">Seleccionar ingrediente</option>
                                            @foreach($ingredients as $ing)
                                                <option value="{{ $ing->id }}" :selected="ingredient.id == {{ $ing->id }}">
                                                    {{ $ing->name }} ({{ $ing->unit }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="w-32">
                                        <input 
                                            type="number" 
                                            step="0.01"
                                            :name="'ingredients[' + index + '][quantity]'" 
                                            x-model="ingredient.quantity"
                                            placeholder="Cantidad"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500"
                                            required
                                        >
                                    </div>

                                    <!-- Unit -->
                                    <div class="w-24">
                                        <input 
                                            type="text" 
                                            :name="'ingredients[' + index + '][unit]'" 
                                            x-model="ingredient.unit"
                                            placeholder="Unidad"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500"
                                        >
                                    </div>

                                    <!-- Remove Button -->
                                    <button 
                                        type="button" 
                                        @click="removeIngredient(index)"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <div x-show="ingredients.length === 0" class="text-center py-4 text-gray-500">
                                No hay ingredientes. Haz clic en "Agregar Ingrediente" para comenzar.
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <x-button variant="secondary" :href="route('recipes.index')">
                            Cancelar
                        </x-button>
                        <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-200">
                            {{ $isEdit ? 'Actualizar' : 'Crear' }} Receta
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>

