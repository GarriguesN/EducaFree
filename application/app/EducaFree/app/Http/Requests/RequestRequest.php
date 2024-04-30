<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\table;

class RequestRequest extends FormRequest
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

    // Se añaden las reglas de validación para el formulario de creación de solicitudes
    public function rules(): array
    {
        return [
            // Rule para que el título de la solicitud sea único y no se repita
            'title' => ['required', 'string', 'max:100', Rule::unique(table: 'requests', column: 'title')->ignore(id: request('requests'), idColumn: 'id')],
            'description' => ['required', 'string', 'max:500']
        ];
    }
    
    // Se añaden los mensajes de validación para el formulario de creación de solicitudes
    public function messages():array{
        return[
            'title.unique' => __('This request has already exists'),
        ];
    }
}
