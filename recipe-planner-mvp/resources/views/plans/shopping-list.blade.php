<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-3xl text-emerald-600">
                    Lista de Compras 🛒
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Plan de la semana del {{ $plan->start_date->format('d/m/Y') }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('plans.download-shopping-list', $plan) }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-200">
                    📥 Descargar CSV
                </a>
                <x-button :href="route('plans.show', $plan)" variant="secondary">
                    Volver al Plan
                </x-button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($shoppingList->count() > 0)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border-t-4 border-emerald-500">
                <!-- Header -->
                <div class="bg-emerald-50 px-6 py-4 border-b border-emerald-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-emerald-700">
                            Ingredientes Necesarios
                        </h3>
                        <span class="inline-flex items-center px-3 py-1 bg-emerald-200 text-emerald-800 rounded-full text-sm font-semibold">
                            {{ $shoppingList->count() }} items
                        </span>
                    </div>
                </div>

                <!-- Shopping List -->
                <div class="p-6">
                    <div class="space-y-3">
                        @foreach($shoppingList as $item)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <label class="flex items-center flex-1 cursor-pointer">
                                    <input type="checkbox" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 mr-4">
                                    <div class="flex-1">
                                        <span class="font-semibold text-gray-800 text-lg">{{ $item['name'] }}</span>
                                        <p class="text-sm text-gray-600 mt-0.5">
                                            Cantidad: {{ number_format($item['quantity'], 2) }} {{ $item['unit'] }}
                                        </p>
                                    </div>
                                </label>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                        {{ $item['unit'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <p class="text-sm text-gray-600">
                            💡 Marca los ingredientes mientras compras
                        </p>
                        <div class="flex gap-2">
                            <a href="{{ route('plans.download-shopping-list', $plan) }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold text-sm shadow-md hover:shadow-lg transition-all">
                                📥 Descargar CSV
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Consejo:</strong> Esta lista incluye todos los ingredientes de las recetas asignadas en tu plan semanal. 
                            Las cantidades ya están sumadas automáticamente.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-md p-16 text-center border-2 border-dashed border-gray-300">
                <div class="text-6xl mb-4">🛒</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Lista Vacía</h3>
                <p class="text-gray-600 mb-6">No hay recetas asignadas en este plan todavía</p>
                <x-button :href="route('plans.show', $plan)">
                    Ir al Plan y Agregar Recetas
                </x-button>
            </div>
        @endif
    </div>
</x-app-layout>

