<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-emerald-600">
            {{ $isEdit ? 'Editar Plan' : 'Nuevo Plan Semanal' }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl shadow-md p-6 border-t-4 border-emerald-500">
            <form action="{{ $isEdit ? route('plans.update', $plan) : route('plans.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <!-- Start Date -->
                    <x-input 
                        type="date"
                        name="start_date"
                        label="Fecha de Inicio (Lunes)"
                        :value="$isEdit ? $plan->start_date->format('Y-m-d') : old('start_date', now()->startOfWeek()->format('Y-m-d'))"
                        required
                    />

                    <!-- Meals Per Day -->
                    <div>
                        <label for="meals_per_day" class="block text-sm font-medium text-gray-700 mb-2">
                            Comidas por Día <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            name="meals_per_day" 
                            id="meals_per_day"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-150 ease-in-out @error('meals_per_day') border-rose-500 @enderror"
                            required
                        >
                            <option value="1" {{ old('meals_per_day', $plan->meals_per_day ?? 3) == 1 ? 'selected' : '' }}>1 comida (ej: solo cena)</option>
                            <option value="2" {{ old('meals_per_day', $plan->meals_per_day ?? 3) == 2 ? 'selected' : '' }}>2 comidas (ej: almuerzo y cena)</option>
                            <option value="3" {{ old('meals_per_day', $plan->meals_per_day ?? 3) == 3 ? 'selected' : '' }}>3 comidas (desayuno, almuerzo, cena)</option>
                            <option value="4" {{ old('meals_per_day', $plan->meals_per_day ?? 3) == 4 ? 'selected' : '' }}>4 comidas</option>
                            <option value="5" {{ old('meals_per_day', $plan->meals_per_day ?? 3) == 5 ? 'selected' : '' }}>5 comidas</option>
                        </select>
                        @error('meals_per_day')
                            <p class="text-rose-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-emerald-700">
                                    Después de crear el plan, podrás asignar recetas a cada día y comida. 
                                    También podrás generar tu lista de compras automáticamente.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <x-button variant="secondary" :href="route('plans.index')">
                            Cancelar
                        </x-button>
                        <x-button type="submit">
                            {{ $isEdit ? 'Actualizar' : 'Crear' }} Plan
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

