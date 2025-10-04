<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-emerald-600">
                    Mis Planes Semanales
                </h2>
                <p class="text-sm text-gray-600 mt-1">Organiza tus comidas de la semana</p>
            </div>
            <x-button :href="route('plans.create')">
                <span class="mr-2">+</span> Nuevo Plan
            </x-button>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($plans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($plans as $plan)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-t-4 border-emerald-500">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                                        Plan del {{ $plan->start_date->format('d/m/Y') }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ $plan->meals_per_day }} comidas por día
                                    </p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1.5 bg-emerald-100 text-emerald-800 rounded-full text-sm font-semibold">
                                    {{ $plan->planItems->count() }} recetas
                                </span>
                            </div>

                            <div class="mb-4 pb-4 border-b border-gray-100">
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="inline-flex items-center px-3 py-1.5 bg-orange-100 text-orange-700 rounded-full font-semibold">
                                        🔥 {{ number_format($plan->total_calories, 0) }} kcal
                                    </span>
                                    <span class="text-gray-600">
                                        📅 {{ $plan->start_date->format('d M') }} - {{ $plan->start_date->addDays(6)->format('d M') }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <x-button :href="route('plans.show', $plan)" class="flex-1 justify-center">
                                    Ver Plan
                                </x-button>
                                <x-button :href="route('plans.shopping-list', $plan)" variant="outline" class="flex-1 justify-center">
                                    🛒 Lista
                                </x-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($plans->hasPages())
                <div class="mt-6">
                    {{ $plans->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-2xl shadow-md p-16 text-center border-2 border-dashed border-gray-300">
                <div class="text-6xl mb-4">📅</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">No tienes planes aún</h3>
                <p class="text-gray-600 mb-6">Crea tu primer plan semanal de comidas</p>
                <x-button :href="route('plans.create')">
                    <span class="mr-2">+</span> Crear Primer Plan
                </x-button>
            </div>
        @endif
    </div>
</x-app-layout>

