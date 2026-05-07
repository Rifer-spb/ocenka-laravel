<?php

namespace App\Manager\Modules\Legal\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'typeId' => 'required|integer',
            'fullName' => 'required|string',
            'shortName' => 'required|string',
            'abbr' => 'required|string',
            'address' => 'required|string',
            'dateOgrn' => 'required|string',
            'inn' => 'required|integer',
            'kpp' => 'required|integer',
            'ogrn' => 'required|integer',
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
