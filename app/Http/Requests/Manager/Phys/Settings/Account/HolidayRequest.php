<?php

namespace App\Http\Requests\Manager\Phys\Settings\Account;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $holidayFrom
 * @property string $holidayTo
 */
class HolidayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'holidayFrom' => 'required|date',
            'holidayTo' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле обязательно для заполнения',
        ];
    }
}
