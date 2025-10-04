<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            Bienvenido al Planificador de Recetas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 mb-8">
                <div class="text-center">
                    <h1 class="text-5xl font-bold text-gray-900 mb-4">
                        🍳 Recipe Planner MVP
                    </h1>
                    <p class="text-xl text-gray-600 mb-6">
                        Organiza tus recetas, planifica tus comidas y genera listas de compras automáticamente
                    </p>
                    <div class="flex justify-center gap-4">
                        <a href="#" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Explorar Recetas
                        </a>
                        <a href="#" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Crear Receta
                        </a>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6">
                    <div class="text-4xl mb-4">📖</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Gestión de Recetas</h3>
                    <p class="text-gray-600">
                        Guarda y organiza todas tus recetas favoritas en un solo lugar
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6">
                    <div class="text-4xl mb-4">📅</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Planificación Semanal</h3>
                    <p class="text-gray-600">
                        Planifica tus comidas de la semana de forma simple y efectiva
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6">
                    <div class="text-4xl mb-4">🛒</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Lista de Compras</h3>
                    <p class="text-gray-600">
                        Genera automáticamente tu lista de compras basada en tu planificación
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

