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
            'value' => 'nullable|string|max:5',
        ];
    }

    public function messages(): array
    {
        return [
            'value.required' => 'Поле обязательно к заполнению',
            'value.max' => 'Значение должно быть не более 5 символов',
        ];
    }
}
