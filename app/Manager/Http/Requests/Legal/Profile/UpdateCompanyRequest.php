<?php

namespace App\Manager\Http\Requests\Legal\Profile;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $typeId
 * @property string $fullName
 * @property string $shortName
 * @property string $abbr
 * @property string $address
 * @property string $dateOgrn
 * @property int $inn
 * @property int $kpp
 * @property int $ogrn
 */
class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'typeId' => 'required|integer|exists:legal_types,id',
            'fullName' => 'required|string|max:255',
            'shortName' => 'required|string|max:255',
            'abbr' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'dateOgrn' => 'required|date',
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
            'max' => 'Поле не должно превышать :max символов',
            'integer' => 'Поле должно быть числом',
        ];
    }
}
