<?php

namespace App\Http\Requests\Manager\Phys\Settings\Account;

use App\Helpers\StringHelper;
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
        $this->merge([
            'phone' => StringHelper::onlyNumbers($this->phone),
        ]);
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|unique:phys_phones,phone',
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
