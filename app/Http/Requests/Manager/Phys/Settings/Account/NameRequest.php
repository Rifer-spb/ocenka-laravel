<?php

namespace App\Http\Requests\Manager\Phys\Settings\Account;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $firstName
 * @property string $secondName
 * @property string $lastName
 */
class NameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstName' => 'required|string',
            'secondName' => 'required|string',
            'lastName' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле обязательно для заполнения',
            'string' => 'Поле должно быть строкой',
        ];
    }
}
