<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'instructions' => ['required', 'string'],
            'servings' => ['required', 'integer', 'min:1'],
            'ingredients' => ['required', 'array', 'min:1'],
            'ingredients.*.id' => ['required', 'exists:ingredients,id'],
            'ingredients.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'ingredients.*.unit' => ['nullable', 'string', 'max:50'],
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
            'title.required' => 'El título de la receta es obligatorio.',
            'instructions.required' => 'Las instrucciones son obligatorias.',
            'servings.required' => 'El número de porciones es obligatorio.',
            'servings.min' => 'Debe haber al menos una porción.',
            'ingredients.required' => 'Debes agregar al menos un ingrediente.',
            'ingredients.min' => 'Debes agregar al menos un ingrediente.',
            'ingredients.*.id.exists' => 'Uno de los ingredientes no existe.',
            'ingredients.*.quantity.required' => 'La cantidad del ingrediente es obligatoria.',
            'ingredients.*.quantity.min' => 'La cantidad debe ser mayor a 0.',
        ];
    }
}
