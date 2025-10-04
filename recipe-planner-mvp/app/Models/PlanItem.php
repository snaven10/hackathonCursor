<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'plan_id',
        'day_of_week',
        'meal_order',
        'recipe_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'day_of_week' => 'integer',
            'meal_order' => 'integer',
        ];
    }

    /**
     * Get the plan that owns the plan item.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the recipe for the plan item.
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * Get day name.
     */
    public function getDayNameAttribute(): string
    {
        $days = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo',
        ];
        
        return $days[$this->day_of_week] ?? '';
    }

    /**
     * Get meal name.
     */
    public function getMealNameAttribute(): string
    {
        $meals = [
            1 => 'Desayuno',
            2 => 'Almuerzo',
            3 => 'Cena',
        ];
        
        return $meals[$this->meal_order] ?? '';
    }
}
