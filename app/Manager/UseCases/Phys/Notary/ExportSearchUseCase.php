<?php

namespace App\Manager\UseCases\Phys\Notary;

use App\Core\Infrastructure\CsvFile;
use App\Core\Models\Notary\Notary;
use App\Manager\Http\Requests\Phys\Notary\SearchRequest;

class ExportSearchUseCase
{
    public function execute(SearchRequest $request): CsvFile
    {
        $rows = $this->search($request);

        $labels = [
            'ФИО',
            'Регион',
            'Индекс',
            'Адрес',
            'Кол-во заказов',
            'Телефоны',
            'E-mails',
            'Комментарий',
        ];

        return CsvFile::create($rows, $labels);
    }

    private function search(SearchRequest $request): array
    {
        return Notary::query()
            ->select(['id', 'region_id', 'name', 'address', 'comment'])
            ->with(['region:id,name', 'phones:notary_id,phone', 'emails:notary_id,email'])
            ->when($request->regionId, fn ($q) => $q->where('region_id', $request->regionId))
            ->when($request->name, fn ($q) => $q->where('name', 'like', "%{$request->name}%"))
            ->when($request->address, fn ($q) => $q->where('address', 'like', "%{$request->address}%"))
            ->when($request->email, fn ($q) => $q->whereRelation('emails', 'email', $request->email))
            ->where('is_work', !$request->notWork)
            ->get()
            ->map(fn (Notary $notary) => $this->getNotary($notary))
            ->all();
    }

    private function getNotary(Notary $notary): array
    {
        list($index, $address) = $this->getAddress($notary->address);

        return [
            $notary->name,
            $notary->region->name,
            $index,
            $address,
            $notary->count_year_orders,
            implode(' ', $notary->phones->pluck('phone')->all()),
            implode(' ', $notary->emails->pluck('email')->all()),
            $notary->comment,
        ];
    }

    private function getAddress(string $address): array
    {
        preg_match('/^([0-9]{1,6}),(.+)/', $address, $addressGroup);

        if (!$addressGroup) {
            return ['',''];
        }

        return [$addressGroup[1], $addressGroup[2]];
    }
}
