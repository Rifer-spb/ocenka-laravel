<?php

namespace App\Manager\Http\Requests\Auth;

use App\Core\Entities\User\Role;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                'max:255',
                'email',
                Rule::exists('users')->where(function (Builder $query) {
                    return $query
                        ->where('username', $this->email)
                        ->whereIn('role', Role::getManagerRoleValues());
                }),
            ],
            'password' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email обязателен для заполнения',
            'email.string' => 'Поле должно быть строкой',
            'email.email' => 'Введите корректный email адрес',
            'email.exists' => 'Пользователь с таким email не найден',
            'email.max' => 'Email не может быть длиннее :max символов',
            'password.max' => 'Пароль не может быть длиннее :max символов',
            'password.required' => 'Пароль обязателен для заполнения',
            'password.string' => 'Поле должно быть строкой',
        ];
    }
}
