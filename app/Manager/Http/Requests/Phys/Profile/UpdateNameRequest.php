<?php

namespace App\Manager\Http\Requests\Phys\Profile;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $firstName
 * @property string $secondName
 * @property string $lastName
 */
class UpdateNameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstName' => 'nullable|string|max:100',
            'secondName' => 'nullable|string|max:100',
            'lastName' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле обязательно для заполнения',
            'string' => 'Поле должно быть строкой',
            'max' => 'Поле :attribute не должно превышать :max символов',
        ];
    }

    public function attributes(): array
    {
        return [
            'firstName' => 'Имя',
            'secondName' => 'Фамилия',
            'lastName' => 'Отчество',
        ];
    }
}
