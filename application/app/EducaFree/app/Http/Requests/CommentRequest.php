<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\table;

class CommentRequest extends FormRequest
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

     // Se añade unas reglas de validación para el campo comment
    public function rules(): array
    {
        return [
            'comment' => ['required', 'string', 'max:100'],
        ];
    }
    
    // Se añaden mensajes de validación para el campo comment, en caso que no se cumplan las reglas
    public function messages():array{
        return[
            'comment.required' => __('Please enter your comment.'),
            'comment.max' => __('Your comment must be less than 100 characters.')
        ];
    }
}
