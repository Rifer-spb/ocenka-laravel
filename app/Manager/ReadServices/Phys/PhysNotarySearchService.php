<?php

namespace App\Manager\ReadServices\Phys;

use App\Core\Entities\Notary\Notary;
use App\Core\Entities\Notary\NotaryEmail;
use App\Core\Entities\Notary\NotaryPhone;
use App\Core\Helpers\PhoneHelper;
use App\Manager\Http\Requests\Phys\Notary\SearchRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class PhysNotarySearchService
{
    public function search(SearchRequest $request): LengthAwarePaginator
    {
        return Notary::query()
            ->select(['id', 'notariat_notary_id', 'region_id', 'name', 'address', 'comment'])
            ->with(['region:id,name', 'phones:notary_id,phone', 'emails:notary_id,email'])
            ->when($request->regionId, fn ($q) => $q->where('region_id', $request->regionId))
            ->when($request->name, fn ($q) => $q->where('name', 'like', "%{$request->name}%"))
            ->when($request->address, fn ($q) => $q->where('address', 'like', "%{$request->address}%"))
            ->when($request->email, fn ($q) => $q->whereRelation('emails', 'email', $request->email))
            ->where('is_work', !$request->notWork)
            ->paginate(perPage: $request->limit)
            ->withQueryString()
            ->appends(['regionId' => $request->regionId ?? ''])
            ->through(fn (Notary $notary) => $this->getNotary($notary));
    }

    private function getNotary(Notary $notary): array
    {
        return [
            'id' => $notary->id,
            'region' => [
                'name' => $notary->region->name,
            ],
            'name' => "$notary->name (NotariatID: $notary->notariat_notary_id)",
            'address' => $notary->address,
            'comment' => $notary->comment,
            'phones' => $notary->phones->map(fn (NotaryPhone $p) => ['phone' => PhoneHelper::toViewFormat($p->phone)])->all(),
            'emails' => $notary->emails->map(fn (NotaryEmail $e) => ['email' => $e->email])->all(),
        ];
    }
}
