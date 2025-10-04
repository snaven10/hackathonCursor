<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'start_date',
        'meals_per_day',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'meals_per_day' => 'integer',
        ];
    }

    /**
     * Get the user that owns the plan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan items for the plan.
     */
    public function planItems(): HasMany
    {
        return $this->hasMany(PlanItem::class);
    }

    /**
     * Get total calories for the plan.
     */
    public function getTotalCaloriesAttribute(): float
    {
        return $this->planItems->sum(function ($item) {
            return $item->recipe->total_calories ?? 0;
        });
    }

    /**
     * Get calories per day array.
     */
    public function getCaloriesPerDay(): array
    {
        $caloriesPerDay = [];
        
        for ($day = 1; $day <= 7; $day++) {
            $caloriesPerDay[$day] = $this->planItems
                ->where('day_of_week', $day)
                ->sum(function ($item) {
                    return $item->recipe->total_calories ?? 0;
                });
        }
        
        return $caloriesPerDay;
    }
}
