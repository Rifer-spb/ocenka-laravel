<?php

namespace App\Manager\Modules\Phys\Http\Requests\Legal\Invite;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $type
 */
class SearchRequest extends FormRequest
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
            'type' => 'required|string|in:inbox,outbox,active,fired',
        ];
    }
}
