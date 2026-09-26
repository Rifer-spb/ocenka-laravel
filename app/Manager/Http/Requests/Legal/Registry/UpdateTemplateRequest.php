<?php

namespace App\Manager\Http\Requests\Legal\Registry;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $template
 */
class UpdateTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'template' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'template.required' => 'Поле обязательно к заполнению',
        ];
    }
}
