<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIngredientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'calories_per_unit' => ['required', 'numeric', 'min:0'],
            'protein_per_unit' => ['nullable', 'numeric', 'min:0'],
            'fat_per_unit' => ['nullable', 'numeric', 'min:0'],
            'carbs_per_unit' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del ingrediente es obligatorio.',
            'unit.required' => 'La unidad de medida es obligatoria.',
            'calories_per_unit.required' => 'Las calorías por unidad son obligatorias.',
            'calories_per_unit.min' => 'Las calorías no pueden ser negativas.',
        ];
    }
}
