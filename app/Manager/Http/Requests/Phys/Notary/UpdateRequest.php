<?php

namespace App\Manager\Http\Requests\Phys\Notary;

use App\Core\Models\Notary\NotaryRegion;
use Illuminate\Foundation\Http\FormRequest;

/**

 */
class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $emails = collect($this->input('emails', []))
            ->filter()
            ->map(fn ($email) => mb_strtolower(trim($email)))
            ->unique()
            ->values()
            ->all();

        $this->merge(['emails' => $emails]);
    }

    public function rules(): array
    {
        return [
            'emails' => ['array', 'min:1', 'max:10'],
            'emails.*' => ['string', 'email', 'max:255'],
            'site' => ['nullable', 'string', 'url', 'max:255'],
            'useDigitalReport' => ['nullable', 'boolean'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'emails' => 'E-mail',
            'emails.*' => 'E-mail',
            'site' => 'сайт',
            'useDigitalReport' => 'приём электронного отчёта',
            'comment' => 'комментарий',
        ];
    }
}
