<?php

namespace App\Manager\Http\Requests\Legal\Call\CommentTemplate;

use Illuminate\Foundation\Http\FormRequest;

class TemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'text' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Необходимо заполнить имя',
            'text.required' => 'Необходимо заполнить комментарий'
        ];
    }
}
