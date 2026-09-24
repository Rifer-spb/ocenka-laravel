<?php

namespace App\Manager\Http\Requests\Phys\Notary;

use App\Core\Models\Notary\NotaryEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string[] $emails
 * @property string $site
 * @property int $useDigitalReport
 * @property string $comment
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
        $notary = $this->route('notary');

        return [
            'emails' => ['array'],
            'emails.*' => [
                'string',
                'email',
                'max:255',
                Rule::unique(NotaryEmail::getTableName(), 'email')
                    ->ignore($notary->id, 'notary_id')
            ],
            'site' => ['nullable', 'string', 'url', 'max:255'],
            'useDigitalReport' => ['nullable', 'boolean'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'emails.*.email' => 'Введите корректный e-mail',
            'emails.*.unique' => 'Такой e-mail уже существует у другого нотариуса',
            'site.url' => 'Некорректный адрес сайта'
        ];
    }
}
