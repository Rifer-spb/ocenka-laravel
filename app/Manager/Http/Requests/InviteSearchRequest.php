<?php

namespace App\Manager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $type
 */
class InviteSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'type' => $this->input('type', 'inbox'),
        ]);
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string|in:inbox,outbox,active,complete',
        ];
    }
}
