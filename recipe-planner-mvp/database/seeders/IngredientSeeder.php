<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            // Proteínas
            ['name' => 'Pechuga de Pollo', 'unit' => 'g', 'calories' => 1.65, 'protein' => 0.31, 'fat' => 0.036, 'carbs' => 0],
            ['name' => 'Carne de Res', 'unit' => 'g', 'calories' => 2.5, 'protein' => 0.26, 'fat' => 0.15, 'carbs' => 0],
            ['name' => 'Salmón', 'unit' => 'g', 'calories' => 2.08, 'protein' => 0.20, 'fat' => 0.13, 'carbs' => 0],
            ['name' => 'Atún', 'unit' => 'g', 'calories' => 1.32, 'protein' => 0.29, 'fat' => 0.01, 'carbs' => 0],
            ['name' => 'Huevo', 'unit' => 'unidad', 'calories' => 155, 'protein' => 13, 'fat' => 11, 'carbs' => 1.1],
            ['name' => 'Queso', 'unit' => 'g', 'calories' => 4.02, 'protein' => 0.25, 'fat' => 0.33, 'carbs' => 0.013],
            
            // Carbohidratos
            ['name' => 'Arroz Blanco', 'unit' => 'g', 'calories' => 1.30, 'protein' => 0.027, 'fat' => 0.003, 'carbs' => 0.28],
            ['name' => 'Pasta', 'unit' => 'g', 'calories' => 1.58, 'protein' => 0.06, 'fat' => 0.009, 'carbs' => 0.31],
            ['name' => 'Pan Integral', 'unit' => 'g', 'calories' => 2.47, 'protein' => 0.13, 'fat' => 0.034, 'carbs' => 0.41],
            ['name' => 'Papa', 'unit' => 'g', 'calories' => 0.77, 'protein' => 0.02, 'fat' => 0.001, 'carbs' => 0.17],
            ['name' => 'Avena', 'unit' => 'g', 'calories' => 3.89, 'protein' => 0.17, 'fat' => 0.069, 'carbs' => 0.66],
            
            // Vegetales
            ['name' => 'Tomate', 'unit' => 'g', 'calories' => 0.18, 'protein' => 0.009, 'fat' => 0.002, 'carbs' => 0.039],
            ['name' => 'Lechuga', 'unit' => 'g', 'calories' => 0.15, 'protein' => 0.014, 'fat' => 0.002, 'carbs' => 0.029],
            ['name' => 'Cebolla', 'unit' => 'g', 'calories' => 0.40, 'protein' => 0.011, 'fat' => 0.001, 'carbs' => 0.093],
            ['name' => 'Zanahoria', 'unit' => 'g', 'calories' => 0.41, 'protein' => 0.009, 'fat' => 0.002, 'carbs' => 0.096],
            ['name' => 'Brócoli', 'unit' => 'g', 'calories' => 0.34, 'protein' => 0.028, 'fat' => 0.004, 'carbs' => 0.069],
            ['name' => 'Espinaca', 'unit' => 'g', 'calories' => 0.23, 'protein' => 0.029, 'fat' => 0.004, 'carbs' => 0.036],
            
            // Frutas
            ['name' => 'Manzana', 'unit' => 'g', 'calories' => 0.52, 'protein' => 0.003, 'fat' => 0.002, 'carbs' => 0.138],
            ['name' => 'Plátano', 'unit' => 'g', 'calories' => 0.89, 'protein' => 0.011, 'fat' => 0.003, 'carbs' => 0.229],
            ['name' => 'Fresa', 'unit' => 'g', 'calories' => 0.32, 'protein' => 0.007, 'fat' => 0.003, 'carbs' => 0.077],
            
            // Lácteos
            ['name' => 'Leche', 'unit' => 'ml', 'calories' => 0.61, 'protein' => 0.032, 'fat' => 0.034, 'carbs' => 0.047],
            ['name' => 'Yogurt Natural', 'unit' => 'g', 'calories' => 0.59, 'protein' => 0.10, 'fat' => 0.004, 'carbs' => 0.047],
            
            // Grasas y Aceites
            ['name' => 'Aceite de Oliva', 'unit' => 'ml', 'calories' => 8.84, 'protein' => 0, 'fat' => 1.0, 'carbs' => 0],
            ['name' => 'Mantequilla', 'unit' => 'g', 'calories' => 7.17, 'protein' => 0.009, 'fat' => 0.81, 'carbs' => 0.006],
            
            // Condimentos
            ['name' => 'Sal', 'unit' => 'g', 'calories' => 0, 'protein' => 0, 'fat' => 0, 'carbs' => 0],
            ['name' => 'Pimienta', 'unit' => 'g', 'calories' => 2.51, 'protein' => 0.10, 'fat' => 0.033, 'carbs' => 0.64],
            ['name' => 'Ajo', 'unit' => 'g', 'calories' => 1.49, 'protein' => 0.064, 'fat' => 0.005, 'carbs' => 0.33],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create([
                'name' => $ingredient['name'],
                'unit' => $ingredient['unit'],
                'calories_per_unit' => $ingredient['calories'],
                'protein_per_unit' => $ingredient['protein'],
                'fat_per_unit' => $ingredient['fat'],
                'carbs_per_unit' => $ingredient['carbs'],
            ]);
        }

        $this->command->info('✓ ' . count($ingredients) . ' ingredientes creados');
    }
}
