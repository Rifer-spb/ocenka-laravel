<?php

namespace App\Manager\UseCases\Phys\Notary;

use App\Core\Helpers\PhoneHelper;
use App\Core\Models\Notary\Notary;
use App\Core\Models\Notary\NotaryEmail;
use App\Core\Models\Notary\NotaryPhone;
use App\Manager\Http\Requests\Phys\Notary\SearchRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class GetPageDataUseCase
{
    public function execute(SearchRequest $request): array
    {
        return [
            'filter' => $request->validated(),
            'notaries' => $this->searchNotaries($request)
        ];
    }

    private function searchNotaries(SearchRequest $request): LengthAwarePaginator
    {
        return Notary::query()
            ->with(['region', 'phones', 'emails'])
            ->when($request->region_id, fn ($q) => $q->where('region_id', $request->region_id))
            ->when($request->name, fn ($q) => $q->where('name', 'like', "%{$request->name}%"))
            ->when($request->address, fn ($q) => $q->where('address', 'like', "%{$request->address}%"))
            ->when($request->email, fn ($q) => $q->whereRelation('emails', 'email', $request->email))
            ->where('is_work', !$request->notWork)
            ->paginate(perPage: $request->limit)
            ->through(fn (Notary $notary) => $this->getNotary($notary));
    }

    private function getNotary(Notary $notary): array
    {
        return [
            'id' => $notary->id,
            'region' => [
                'name' => $notary->region->name,
            ],
            'name' => $notary->name,
            'address' => $notary->address,
            'comment' => $notary->comment,
            'phones' => $notary->phones->map(fn (NotaryPhone $p) => ['phone' => PhoneHelper::toViewFormat($p->phone)])->all(),
            'emails' => $notary->emails->map(fn (NotaryEmail $e) => ['email' => $e->email])->all(),
        ];
    }
}
