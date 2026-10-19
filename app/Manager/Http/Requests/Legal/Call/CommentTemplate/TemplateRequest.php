<?php

namespace App\Manager\Http\Requests\Legal\Call\CommentTemplate;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $text
 */
class TemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'text' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Необходимо заполнить имя',
            'name.max' => 'Максимальная длинна 255 символов',
            'text.required' => 'Необходимо заполнить текст шаблона'
        ];
    }
}
