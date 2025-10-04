<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-3xl text-emerald-600">
                    Plan Semanal
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Semana del {{ $plan->start_date->format('d/m/Y') }} al {{ $plan->start_date->addDays(6)->format('d/m/Y') }}
                </p>
            </div>
            <div class="flex gap-2">
                <x-button :href="route('plans.shopping-list', $plan)" variant="outline">
                    🛒 Lista de Compras
                </x-button>
                <x-button :href="route('plans.edit', $plan)" variant="secondary">
                    Editar
                </x-button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Summary Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-emerald-500">
                <p class="text-sm text-gray-600">Total Calorías Semana</p>
                <p class="text-3xl font-bold text-emerald-600">{{ number_format($plan->total_calories, 0) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-blue-500">
                <p class="text-sm text-gray-600">Recetas Asignadas</p>
                <p class="text-3xl font-bold text-blue-600">{{ $plan->planItems->count() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-amber-500">
                <p class="text-sm text-gray-600">Comidas por Día</p>
                <p class="text-3xl font-bold text-amber-600">{{ $plan->meals_per_day }}</p>
            </div>
        </div>

        <!-- Weekly Grid -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden border-t-4 border-emerald-500">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-emerald-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-emerald-700 uppercase sticky left-0 bg-emerald-50">
                                Comida
                            </th>
                            @php
                                $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                $mealNames = ['Desayuno', 'Almuerzo', 'Cena', 'Merienda', 'Snack'];
                            @endphp
                            @foreach($days as $dayIndex => $dayName)
                                <th class="px-4 py-3 text-center text-xs font-bold text-emerald-700 uppercase">
                                    {{ $dayName }}
                                    <div class="text-gray-500 font-normal text-xs mt-1">
                                        {{ $plan->start_date->addDays($dayIndex)->format('d/m') }}
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @for($meal = 1; $meal <= $plan->meals_per_day; $meal++)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-700 sticky left-0 bg-white">
                                    {{ $mealNames[$meal - 1] }}
                                </td>
                                @for($day = 1; $day <= 7; $day++)
                                    @php
                                        $planItem = $plan->planItems->where('day_of_week', $day)->where('meal_order', $meal)->first();
                                    @endphp
                                    <td class="px-2 py-2" x-data="{ showModal: false }">
                                        @if($planItem && $planItem->recipe)
                                            <!-- Recipe Card -->
                                            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3 hover:shadow-md transition-shadow cursor-pointer group">
                                                <h4 class="text-sm font-semibold text-gray-800 line-clamp-2 group-hover:text-emerald-600 mb-2">
                                                    {{ $planItem->recipe->title }}
                                                </h4>
                                                <p class="text-xs text-gray-600 mb-2">
                                                    🔥 {{ number_format($planItem->recipe->total_calories ?? 0, 0) }} kcal
                                                </p>
                                                <div class="flex gap-1">
                                                    <a href="{{ route('recipes.show', $planItem->recipe) }}" 
                                                       class="flex-1 text-center px-2 py-1 bg-emerald-500 hover:bg-emerald-600 text-white rounded text-xs font-medium transition">
                                                        Ver
                                                    </a>
                                                    <button 
                                                        @click="showModal = true"
                                                        type="button"
                                                        class="px-2 py-1 bg-gray-500 hover:bg-gray-600 text-white rounded text-xs font-medium transition">
                                                        Cambiar
                                                    </button>
                                                    <form action="{{ route('plan-items.destroy', $planItem) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button 
                                                            type="submit"
                                                            onclick="return confirm('¿Eliminar esta receta del plan?')"
                                                            class="px-2 py-1 bg-rose-500 hover:bg-rose-600 text-white rounded text-xs font-medium transition">
                                                            ✕
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Modal para cambiar receta -->
                                            <div x-show="showModal" 
                                                 x-cloak
                                                 class="fixed inset-0 z-50 overflow-y-auto" 
                                                 @click.self="showModal = false">
                                                <div class="flex items-center justify-center min-h-screen p-4">
                                                    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-y-auto">
                                                        <div class="p-6">
                                                            <h3 class="text-lg font-bold text-gray-900 mb-4">Cambiar Receta</h3>
                                                            <form action="{{ route('plan-items.update', $planItem) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="space-y-2 mb-4">
                                                                    @foreach($recipes as $recipe)
                                                                        <label class="flex items-center p-3 hover:bg-emerald-50 rounded-lg cursor-pointer border border-gray-200">
                                                                            <input type="radio" name="recipe_id" value="{{ $recipe->id }}" {{ $planItem->recipe_id == $recipe->id ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500">
                                                                            <span class="ml-3 flex-1">
                                                                                <span class="font-medium text-gray-900">{{ $recipe->title }}</span>
                                                                                <span class="text-sm text-gray-500 ml-2">({{ number_format($recipe->total_calories ?? 0, 0) }} kcal)</span>
                                                                            </span>
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                                <div class="flex justify-end gap-2">
                                                                    <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium">Cancelar</button>
                                                                    <button type="submit" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg font-medium">Actualizar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Empty Slot - Add Recipe -->
                                            <button 
                                                @click="showModal = true"
                                                type="button"
                                                class="w-full h-24 border-2 border-dashed border-gray-300 rounded-lg hover:border-emerald-500 hover:bg-emerald-50 transition-all flex items-center justify-center group">
                                                <span class="text-gray-400 group-hover:text-emerald-600 text-2xl">+</span>
                                            </button>

                                            <!-- Modal para agregar receta -->
                                            <div x-show="showModal" 
                                                 x-cloak
                                                 class="fixed inset-0 z-50 overflow-y-auto" 
                                                 @click.self="showModal = false">
                                                <div class="flex items-center justify-center min-h-screen p-4">
                                                    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-y-auto">
                                                        <div class="p-6">
                                                            <h3 class="text-lg font-bold text-gray-900 mb-4">Seleccionar Receta</h3>
                                                            <form action="{{ route('plan-items.store') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                                                <input type="hidden" name="day_of_week" value="{{ $day }}">
                                                                <input type="hidden" name="meal_order" value="{{ $meal }}">
                                                                
                                                                <div class="space-y-2 mb-4">
                                                                    @foreach($recipes as $recipe)
                                                                        <label class="flex items-center p-3 hover:bg-emerald-50 rounded-lg cursor-pointer border border-gray-200">
                                                                            <input type="radio" name="recipe_id" value="{{ $recipe->id }}" required class="text-emerald-600 focus:ring-emerald-500">
                                                                            <span class="ml-3 flex-1">
                                                                                <span class="font-medium text-gray-900">{{ $recipe->title }}</span>
                                                                                <span class="text-sm text-gray-500 ml-2">({{ number_format($recipe->total_calories ?? 0, 0) }} kcal)</span>
                                                                            </span>
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                                <div class="flex justify-end gap-2">
                                                                    <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium">Cancelar</button>
                                                                    <button type="submit" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg font-medium">Agregar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Calories Per Day -->
        <div class="mt-6 bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Calorías por Día</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
                @foreach($days as $dayIndex => $dayName)
                    @php
                        $dayNum = $dayIndex + 1;
                        $calories = $caloriesPerDay[$dayNum] ?? 0;
                    @endphp
                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                        <p class="text-xs font-medium text-gray-600 mb-1">{{ $dayName }}</p>
                        <p class="text-xl font-bold text-emerald-600">{{ number_format($calories, 0) }}</p>
                        <p class="text-xs text-gray-500">kcal</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>

