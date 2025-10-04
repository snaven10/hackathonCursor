<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificar si el usuario ya existe
        $existingUser = DB::table('users')->where('email', 'admin@recipeapp.com')->first();
        
        if (!$existingUser) {
            // Insertar usuario admin por defecto solo si no existe
            $userId = DB::table('users')->insertGetId([
                'name' => 'Admin',
                'email' => 'admin@recipeapp.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Asignar rol de admin al usuario
            $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
            
            if ($adminRoleId) {
                DB::table('model_has_roles')->insert([
                    'role_id' => $adminRoleId,
                    'model_type' => 'App\\Models\\User',
                    'model_id' => $userId,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar usuario admin
        $userId = DB::table('users')->where('email', 'admin@recipeapp.com')->value('id');
        
        if ($userId) {
            // Eliminar relación con roles
            DB::table('model_has_roles')
                ->where('model_type', 'App\\Models\\User')
                ->where('model_id', $userId)
                ->delete();
            
            // Eliminar usuario
            DB::table('users')->where('id', $userId)->delete();
        }
    }
};
