<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $isEdit ? 'Editar Ingrediente' : 'Nuevo Ingrediente' }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ $isEdit ? route('ingredients.update', $ingredient) : route('ingredients.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre del Ingrediente <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', $ingredient->name) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                            required
                        >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Unit -->
                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                            Unidad de Medida <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="unit" 
                            id="unit" 
                            value="{{ old('unit', $ingredient->unit) }}"
                            placeholder="g, ml, unidad, etc."
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('unit') border-red-500 @enderror"
                            required
                        >
                        @error('unit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nutritional Values Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Calories -->
                        <div>
                            <label for="calories_per_unit" class="block text-sm font-medium text-gray-700 mb-2">
                                Calorías por Unidad <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                step="0.01"
                                name="calories_per_unit" 
                                id="calories_per_unit" 
                                value="{{ old('calories_per_unit', $ingredient->calories_per_unit) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('calories_per_unit') border-red-500 @enderror"
                                required
                            >
                            @error('calories_per_unit')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Protein -->
                        <div>
                            <label for="protein_per_unit" class="block text-sm font-medium text-gray-700 mb-2">
                                Proteínas (g) por Unidad
                            </label>
                            <input 
                                type="number" 
                                step="0.01"
                                name="protein_per_unit" 
                                id="protein_per_unit" 
                                value="{{ old('protein_per_unit', $ingredient->protein_per_unit) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('protein_per_unit') border-red-500 @enderror"
                            >
                            @error('protein_per_unit')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fat -->
                        <div>
                            <label for="fat_per_unit" class="block text-sm font-medium text-gray-700 mb-2">
                                Grasas (g) por Unidad
                            </label>
                            <input 
                                type="number" 
                                step="0.01"
                                name="fat_per_unit" 
                                id="fat_per_unit" 
                                value="{{ old('fat_per_unit', $ingredient->fat_per_unit) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('fat_per_unit') border-red-500 @enderror"
                            >
                            @error('fat_per_unit')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Carbs -->
                        <div>
                            <label for="carbs_per_unit" class="block text-sm font-medium text-gray-700 mb-2">
                                Carbohidratos (g) por Unidad
                            </label>
                            <input 
                                type="number" 
                                step="0.01"
                                name="carbs_per_unit" 
                                id="carbs_per_unit" 
                                value="{{ old('carbs_per_unit', $ingredient->carbs_per_unit) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('carbs_per_unit') border-red-500 @enderror"
                            >
                            @error('carbs_per_unit')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <x-button type="secondary" :href="route('ingredients.index')">
                            Cancelar
                        </x-button>
                        <x-button type="submit">
                            {{ $isEdit ? 'Actualizar' : 'Crear' }} Ingrediente
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

