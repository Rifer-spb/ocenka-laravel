<?php

namespace App\Manager\Http\Requests\Phys\Notary;

use App\Core\Models\Notary\NotaryRegion;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property null|integer $regionId
 * @property null|string $name
 * @property null|string $address
 * @property bool $notWork
 * @property string $email
 */
class SearchRequest extends FormRequest
{
    public int $limit = 20;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'regionId' => $this->input('regionId', NotaryRegion::ID_SAINT_PETERSBURG),
        ]);
    }

    public function rules(): array
    {
        return [
            'regionId' => 'nullable|integer|exists:notary_regions,id',
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'notWork' => 'boolean',
        ];
    }
}
