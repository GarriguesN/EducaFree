<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\table;

class UpdateInfoRequest extends FormRequest
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

    // Se añaden las reglas de validación para el formulario de actualizacion de datos del usuario
    public function rules(): array
    {
        // Se obtiene el id del usuario que se esta actualizando para que no se pueda repetir el nombre ni el email
        $userId = $this->route('id');
        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($userId, 'id')],
            'email' => ['required', 'string', 'email', 'max:50', Rule::unique('users')->ignore($userId)]
        ];
    }
    
    // Se añaden los mensajes de error para el formulario de actualizacion de datos del usuario
    public function messages():array{
        return[
            'name.unique' => __('This name has been already taken'),
            'email' => __('Please use a correct email'),
        ];
    }
}
