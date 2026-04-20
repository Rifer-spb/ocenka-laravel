<?php

namespace App\Http\Requests\Auth;

use App\Models\User\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

/**
 * @property string $email
 * @property string $password
 */
class SignInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::exists('users')->where(function (Builder $query) {
                    return $query
                        ->where('name', $this->email)
                        ->whereIn('role', Role::managerRoles());
                }),
            ],
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email обязателен для заполнения',
            'email.string' => 'Поле должно быть строкой',
            'email.email' => 'Введите корректный email адрес',
            'email.exists' => 'Пользователь с таким email не найден',
            'email.max' => 'Email не может быть длиннее 255 символов',
            'password.required' => 'Пароль обязателен для заполнения',
            'password.string' => 'Поле должно быть строкой',
        ];
    }
}
