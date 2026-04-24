<?php

namespace App\Http\Requests\Manager\Phys\Settings\Account;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $oldPassword
 * @property string $newPassword
 */
class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string|min:8|confirmed',
        ];
    }
}
