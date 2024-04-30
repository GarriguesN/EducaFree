<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\table;

class UpdatePasswordRequest extends FormRequest
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

    // Reglas de validación para el cambio de contraseña del usuario
    public function rules(): array
    {
        return [
            'currentPassword' => ['required', 'string'],
            'newPassword' => ['required', 'string', 'min:8', 'different:currentPassword'],
            'repeatPassword' => ['required', 'string', 'min:8', 'same:newPassword'],
        ];
    }
    
    // Mensajes de validación para el cambio de contraseña del usuario
    public function messages():array{
        return[
            'currentPassword.required' => __('The current password field is required'),
            'newPassword.required' => __('The new password field is required'),
            'newPassword.min' => __('The new password must be at least :min characters'),
            'newPassword.different' => __('The new password must be different from the current password'),
            'repeatPassword.required' => __('The repeat password field is required'),
            'repeatPassword.min' => __('The repeat password must be at least :min characters'),
            'repeatPassword.same' => __('The repeat password must match the new password'),
        ];
    }
}
