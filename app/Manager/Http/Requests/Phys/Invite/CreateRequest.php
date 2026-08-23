<?php

namespace App\Manager\Http\Requests\Phys\Invite;

use App\Core\Models\User\Role;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $email
 */
class CreateRequest extends FormRequest
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
                'email',
                Rule::exists('users')->where(function (Builder $query) {
                    return $query
                        ->where('username', $this->email)
                        ->where('role', Role::LEGAL->value);
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Поле обязательно к заполнению',
            'email.email' => 'Некорректный e-mail адрес',
            'email.exists' => 'Юр.лицо с указанным e-mail не найден',
        ];
    }
}
