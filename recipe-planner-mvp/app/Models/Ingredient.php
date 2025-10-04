<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'unit',
        'calories_per_unit',
        'protein_per_unit',
        'fat_per_unit',
        'carbs_per_unit',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'calories_per_unit' => 'float',
            'protein_per_unit' => 'float',
            'fat_per_unit' => 'float',
            'carbs_per_unit' => 'float',
        ];
    }

    /**
     * The recipes that belong to the ingredient.
     */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)
            ->withPivot(['quantity', 'unit'])
            ->withTimestamps();
    }
}
