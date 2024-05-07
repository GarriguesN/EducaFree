<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\table;

class CourseRequest extends FormRequest
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

    // Se añade unas reglas de validación para el campo name
    // Se añade una regla de validación para el campo description
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }
    
    // Se añaden mensajes de validación para el campo name
    // Se añade un mensaje de validación para el campo description
    public function messages():array{
        return[
            'name.required' => __('Please enter the course name.'),
            'name.max' => __('The course name must be less than 255 characters.'),
            'description.required' => __('Please enter the course description.'),
        ];
    }
}
