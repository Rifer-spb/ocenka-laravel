<?php

namespace App\Manager\Http\Requests\Legal\Employee;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $value
 */
class UpdatePhoneExtensionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => ['nullable', 'string', 'regex:/^(?=.*[1-9])\d{1,3}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'value.regex' => 'Значение должно быть от 1 до 3 цифр',
        ];
    }
}
