<?php

namespace App\Manager\Http\Requests\Phys\Profile;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $holidayFrom
 * @property string $holidayTo
 */
class UpdateHolidayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'holidayFrom' => 'required|date',
            'holidayTo' => 'required|date|after:holidayFrom',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле обязательно для заполнения',
            'after' => 'Дата должна быть больше чем дата От',
        ];
    }
}
