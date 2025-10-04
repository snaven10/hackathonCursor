<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function __construct(
        private RecipeService $recipeService
    ) {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipes = [
            [
                'title' => 'Pollo al Horno con Vegetales',
                'description' => 'Una deliciosa y saludable comida completa con proteínas y vegetales asados.',
                'instructions' => "1. Precalentar el horno a 180°C.\n2. Sazonar la pechuga de pollo con sal, pimienta y ajo.\n3. Cortar las zanahorias y papas en cubos.\n4. Colocar todo en una bandeja y rociar con aceite de oliva.\n5. Hornear por 40 minutos o hasta que esté dorado.\n6. Servir caliente.",
                'servings' => 4,
                'ingredients' => [
                    ['name' => 'Pechuga de Pollo', 'quantity' => 600, 'unit' => 'g'],
                    ['name' => 'Papa', 'quantity' => 400, 'unit' => 'g'],
                    ['name' => 'Zanahoria', 'quantity' => 200, 'unit' => 'g'],
                    ['name' => 'Aceite de Oliva', 'quantity' => 20, 'unit' => 'ml'],
                    ['name' => 'Sal', 'quantity' => 5, 'unit' => 'g'],
                    ['name' => 'Pimienta', 'quantity' => 2, 'unit' => 'g'],
                    ['name' => 'Ajo', 'quantity' => 10, 'unit' => 'g'],
                ],
            ],
            [
                'title' => 'Pasta con Salmón y Espinacas',
                'description' => 'Una pasta cremosa y nutritiva con omega-3 del salmón.',
                'instructions' => "1. Cocinar la pasta según las instrucciones del paquete.\n2. En una sartén, cocinar el salmón en aceite de oliva.\n3. Agregar espinacas y cocinar hasta que se marchiten.\n4. Mezclar con la pasta cocida.\n5. Servir con queso rallado encima.",
                'servings' => 2,
                'ingredients' => [
                    ['name' => 'Pasta', 'quantity' => 200, 'unit' => 'g'],
                    ['name' => 'Salmón', 'quantity' => 300, 'unit' => 'g'],
                    ['name' => 'Espinaca', 'quantity' => 100, 'unit' => 'g'],
                    ['name' => 'Queso', 'quantity' => 50, 'unit' => 'g'],
                    ['name' => 'Aceite de Oliva', 'quantity' => 15, 'unit' => 'ml'],
                    ['name' => 'Ajo', 'quantity' => 5, 'unit' => 'g'],
                ],
            ],
            [
                'title' => 'Ensalada de Atún',
                'description' => 'Ensalada fresca y ligera, perfecta para el almuerzo.',
                'instructions' => "1. Lavar y cortar la lechuga y tomates.\n2. Escurrir el atún enlatado.\n3. Mezclar todos los vegetales en un bowl.\n4. Agregar el atún.\n5. Aliñar con aceite de oliva y sal.\n6. Servir fresca.",
                'servings' => 2,
                'ingredients' => [
                    ['name' => 'Atún', 'quantity' => 160, 'unit' => 'g'],
                    ['name' => 'Lechuga', 'quantity' => 150, 'unit' => 'g'],
                    ['name' => 'Tomate', 'quantity' => 200, 'unit' => 'g'],
                    ['name' => 'Cebolla', 'quantity' => 50, 'unit' => 'g'],
                    ['name' => 'Aceite de Oliva', 'quantity' => 10, 'unit' => 'ml'],
                    ['name' => 'Sal', 'quantity' => 2, 'unit' => 'g'],
                ],
            ],
            [
                'title' => 'Desayuno Completo con Huevos',
                'description' => 'Un desayuno nutritivo y energético para comenzar el día.',
                'instructions' => "1. Tostar el pan integral.\n2. Freír los huevos al gusto.\n3. Preparar una pequeña ensalada con tomate y espinaca.\n4. Servir todo junto con una manzana.\n5. ¡Buen provecho!",
                'servings' => 1,
                'ingredients' => [
                    ['name' => 'Huevo', 'quantity' => 2, 'unit' => 'unidad'],
                    ['name' => 'Pan Integral', 'quantity' => 60, 'unit' => 'g'],
                    ['name' => 'Tomate', 'quantity' => 100, 'unit' => 'g'],
                    ['name' => 'Espinaca', 'quantity' => 30, 'unit' => 'g'],
                    ['name' => 'Manzana', 'quantity' => 150, 'unit' => 'g'],
                    ['name' => 'Mantequilla', 'quantity' => 10, 'unit' => 'g'],
                ],
            ],
            [
                'title' => 'Bowl de Avena con Frutas',
                'description' => 'Desayuno saludable y energético con fibra y vitaminas.',
                'instructions' => "1. Cocinar la avena con leche.\n2. Cortar el plátano y fresas en rodajas.\n3. Servir la avena en un bowl.\n4. Decorar con las frutas cortadas.\n5. Opcionalmente agregar un poco de yogurt.",
                'servings' => 1,
                'ingredients' => [
                    ['name' => 'Avena', 'quantity' => 50, 'unit' => 'g'],
                    ['name' => 'Leche', 'quantity' => 200, 'unit' => 'ml'],
                    ['name' => 'Plátano', 'quantity' => 120, 'unit' => 'g'],
                    ['name' => 'Fresa', 'quantity' => 100, 'unit' => 'g'],
                    ['name' => 'Yogurt Natural', 'quantity' => 50, 'unit' => 'g'],
                ],
            ],
            [
                'title' => 'Carne con Arroz y Brócoli',
                'description' => 'Comida completa y balanceada, rica en proteínas y nutrientes.',
                'instructions' => "1. Cocinar el arroz blanco.\n2. Sazonar la carne y cocinarla en una sartén.\n3. Cocinar el brócoli al vapor.\n4. Servir todo junto.\n5. Agregar sal al gusto.",
                'servings' => 3,
                'ingredients' => [
                    ['name' => 'Carne de Res', 'quantity' => 450, 'unit' => 'g'],
                    ['name' => 'Arroz Blanco', 'quantity' => 300, 'unit' => 'g'],
                    ['name' => 'Brócoli', 'quantity' => 300, 'unit' => 'g'],
                    ['name' => 'Aceite de Oliva', 'quantity' => 15, 'unit' => 'ml'],
                    ['name' => 'Sal', 'quantity' => 5, 'unit' => 'g'],
                    ['name' => 'Ajo', 'quantity' => 8, 'unit' => 'g'],
                ],
            ],
        ];

        foreach ($recipes as $recipeData) {
            // Crear la receta
            $recipe = Recipe::create([
                'title' => $recipeData['title'],
                'description' => $recipeData['description'],
                'instructions' => $recipeData['instructions'],
                'servings' => $recipeData['servings'],
            ]);

            // Asociar ingredientes
            $ingredientsData = [];
            foreach ($recipeData['ingredients'] as $ingredientData) {
                $ingredient = Ingredient::where('name', $ingredientData['name'])->first();
                if ($ingredient) {
                    $ingredientsData[] = [
                        'id' => $ingredient->id,
                        'quantity' => $ingredientData['quantity'],
                        'unit' => $ingredientData['unit'],
                    ];
                }
            }

            // Sincronizar ingredientes y calcular nutrición
            $this->recipeService->syncIngredients($recipe, $ingredientsData);
        }

        $this->command->info('✓ ' . count($recipes) . ' recetas creadas con ingredientes');
    }
}
