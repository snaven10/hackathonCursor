<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanItem;
use App\Models\Recipe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@recipeapp.com')->first();
        
        if (!$admin) {
            $this->command->warn('Usuario admin no encontrado. Saltando PlanSeeder.');
            return;
        }

        $recipes = Recipe::all();
        
        if ($recipes->count() < 3) {
            $this->command->warn('No hay suficientes recetas. Ejecuta RecipeSeeder primero.');
            return;
        }

        // Crear plan de ejemplo para la semana actual
        $plan = Plan::create([
            'user_id' => $admin->id,
            'start_date' => Carbon::now()->startOfWeek(),
            'meals_per_day' => 3,
        ]);

        // Asignar algunas recetas al plan
        $assignments = [
            // Lunes
            ['day' => 1, 'meal' => 1, 'recipe' => 'Bowl de Avena con Frutas'],
            ['day' => 1, 'meal' => 2, 'recipe' => 'Ensalada de Atún'],
            ['day' => 1, 'meal' => 3, 'recipe' => 'Pollo al Horno con Vegetales'],
            
            // Martes
            ['day' => 2, 'meal' => 1, 'recipe' => 'Desayuno Completo con Huevos'],
            ['day' => 2, 'meal' => 2, 'recipe' => 'Pasta con Salmón y Espinacas'],
            ['day' => 2, 'meal' => 3, 'recipe' => 'Carne con Arroz y Brócoli'],
            
            // Miércoles
            ['day' => 3, 'meal' => 1, 'recipe' => 'Bowl de Avena con Frutas'],
            ['day' => 3, 'meal' => 2, 'recipe' => 'Pollo al Horno con Vegetales'],
            ['day' => 3, 'meal' => 3, 'recipe' => 'Ensalada de Atún'],
            
            // Jueves
            ['day' => 4, 'meal' => 1, 'recipe' => 'Desayuno Completo con Huevos'],
            ['day' => 4, 'meal' => 2, 'recipe' => 'Carne con Arroz y Brócoli'],
            
            // Viernes
            ['day' => 5, 'meal' => 1, 'recipe' => 'Bowl de Avena con Frutas'],
            ['day' => 5, 'meal' => 2, 'recipe' => 'Pasta con Salmón y Espinacas'],
            ['day' => 5, 'meal' => 3, 'recipe' => 'Pollo al Horno con Vegetales'],
        ];

        $createdItems = 0;
        foreach ($assignments as $assignment) {
            $recipe = $recipes->firstWhere('title', $assignment['recipe']);
            
            if ($recipe) {
                PlanItem::create([
                    'plan_id' => $plan->id,
                    'day_of_week' => $assignment['day'],
                    'meal_order' => $assignment['meal'],
                    'recipe_id' => $recipe->id,
                ]);
                $createdItems++;
            }
        }

        $this->command->info('✓ Plan semanal creado con ' . $createdItems . ' comidas asignadas');
        
        // Crear un segundo plan para la próxima semana (vacío)
        Plan::create([
            'user_id' => $admin->id,
            'start_date' => Carbon::now()->addWeek()->startOfWeek(),
            'meals_per_day' => 3,
        ]);
        
        $this->command->info('✓ Plan adicional creado para planificación futura');
    }
}
