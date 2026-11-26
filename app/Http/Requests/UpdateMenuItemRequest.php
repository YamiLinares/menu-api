<?php

namespace App\Http\Requests;

use App\Models\MenuItem;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $required = $this->isMethod('PUT') ? 'required' : 'sometimes';

        return [
            'name' => [$required, 'string', 'max:120'],
            'description' => [$required, 'string', 'max:2000'],
            'price' => [$required, 'numeric', 'min:0', 'decimal:0,2', 'max:99999999.99'],
            'category' => [$required, 'string', Rule::in(MenuItem::CATEGORIES)],
            'is_available' => [$required, 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del platillo es obligatorio.',
            'name.max' => 'El nombre no puede superar los 120 caracteres.',
            'description.required' => 'La descripción es obligatoria.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio debe ser mayor o igual a cero.',
            'price.decimal' => 'El precio debe tener como máximo dos decimales.',
            'category.required' => 'La categoría es obligatoria.',
            'category.in' => 'La categoría seleccionada no es válida.',
            'is_available.required' => 'La disponibilidad es obligatoria.',
            'is_available.boolean' => 'La disponibilidad debe ser verdadera o falsa.',
        ];
    }

    public function validationData(): array
    {
        return array_intersect_key($this->all(), array_flip(['name', 'description', 'price', 'category', 'is_available']));
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Los datos proporcionados no son válidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
