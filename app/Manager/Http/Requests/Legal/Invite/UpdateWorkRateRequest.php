<?php

namespace App\Manager\Http\Requests\Legal\Invite;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $value
 */
class UpdateWorkRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->value === null) {
            $this->merge(['value' => 0]);
        }
    }

    public function rules(): array
    {
        return [
            'value' => 'integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'value.required' => 'Поле обязательно к заполнению',
            'value.integer' => 'Значение должно быть числом',
            'value.min' => 'Значение не может быть отрицательным',
        ];
    }
}
