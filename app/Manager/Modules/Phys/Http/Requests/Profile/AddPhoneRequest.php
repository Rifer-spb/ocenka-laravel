<?php

namespace App\Manager\Modules\Phys\Http\Requests\Profile;

use App\Core\Helpers\StringHelper;
use App\Core\Validators\PhoneValidator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $phone
 */
class AddPhoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->phone === null) {
            return;
        }

        $this->merge([
            'phone' => StringHelper::onlyNumbers($this->phone),
        ]);
    }

    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'string',
                'unique:phys_phones,phone',
                function ($attribute, $value, $fail) {
                    if (!PhoneValidator::isNational($value)) {
                        $fail('Некорректный номер телефона');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Поле обязательно к заполнению',
            'phone.unique' => 'Такой номер уже добавлен',
        ];
    }
}
