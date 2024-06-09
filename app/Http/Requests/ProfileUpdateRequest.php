<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nombres' => ['required', 'string', 'max:100'],
            'apepat' => ['required', 'string', 'max:100'],
            'apemat' => ['required', 'string', 'max:100'],
            'fechanac' => ['required', 'date'],
            'telefono' => ['required', 'string', 'max:20'],
            'rol' => ['required', 'in:medico,secretaria,colaborador'],
            'activo' => ['required', 'in:si,no'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
