<?php

namespace App\Manager\Modules\Phys\Http\Requests\Profile;

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
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле обязательно к заполнению',
            'newPassword.min' => 'Поле должно быть минимум 8 символов',
            'newPassword.confirmed' => 'Пароли не совпадают',
        ];
    }
}
