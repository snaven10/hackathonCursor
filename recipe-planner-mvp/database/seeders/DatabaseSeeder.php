<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles and permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@recipeapp.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // Create test user
        $user = User::firstOrCreate(
            ['email' => 'user@recipeapp.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole('user');

        $this->command->info('Users created:');
        $this->command->info('Admin: admin@recipeapp.com / password');
        $this->command->info('User: user@recipeapp.com / password');

        // Seed ingredients, recipes, and plans
        $this->call([
            IngredientSeeder::class,
            RecipeSeeder::class,
            PlanSeeder::class,
        ]);
    }
}
