<?php

namespace App\Manager\Http\Requests\Phys\Notary;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property null|integer $region_id
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

    public function rules(): array
    {
        return [
            'region_id' => 'nullable|integer|exists:notary_regions,id',
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'notWork' => 'boolean',
        ];
    }

    protected function defaults(): array
    {
        return [
            'notWork' => false,
        ];
    }
}
