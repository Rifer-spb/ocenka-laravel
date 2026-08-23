<?php

namespace App\Manager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $oldPassword
 * @property string $newPassword
 */
class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'oldPassword' => 'required|string|current_password',
            'newPassword' => 'required|string|min:8|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле обязательно к заполнению',
            'newPassword.min' => 'Поле должно быть минимум 8 символов',
            'newPassword.max' => 'Поле должно быть не больше 50 символов',
            'oldPassword.current_password' => 'Текущий пароль неверен',
        ];
    }
}
