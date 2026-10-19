<?php

namespace App\Manager\Http\Requests\Legal\Employee;

use App\Core\Entities\Employee\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'value' => [
                'nullable',
                'string',
                'regex:/^(?=.*[1-9])\d{1,3}$/',
                Rule::unique(Employee::getTableName(), 'phone_extension')
                    ->where('legal_id', $this->user()->id)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'value.regex' => 'Значение должно быть от 1 до 3 цифр',
            'value.unique' => 'Номер уже занят'
        ];
    }
}
