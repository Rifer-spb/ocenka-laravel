<?php

namespace App\Core\Services\Mango;

use App\Core\Entities\Call\Call;
use App\Core\Events\WebSocket\EventType;
use App\Core\Events\WebSocket\UserEvent;
use App\Core\Finders\CallFinder;
use App\Core\Finders\EmployeeFinder;
use App\Core\Finders\LegalFinder;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

class MangoService
{
    /**
     * @throws \Throwable
     */
    public function appeared(string $entryId, int $phoneFrom, int $phoneTo, CarbonImmutable $appearedAt): AppearedResult
    {
        ArgumentValidator::validateEntryId($entryId);
        ArgumentValidator::validateFrom($phoneFrom);
        ArgumentValidator::validateTo($phoneTo);

        if (CallFinder::hasByMangoId($entryId)) {
            Log::warning('Звонок уже добавлен', ['mango_call_id' => $entryId]);
            return AppearedResult::AlreadyExists;
        }

        if (! $legal = LegalFinder::findByPhone($phoneTo)) {
            Log::warning('Юрлицо не найдено', ['phone' => $phoneTo]);
            return AppearedResult::LegalNotFound;
        }

        $call = Call::createNew(
            $legal,
            $entryId,
            $phoneFrom,
            $phoneTo,
            $appearedAt
        );

        $personIds = EmployeeFinder::getAllPhysIdWithCallAccess($legal);

        if (! $personIds) {
            Log::warning('Сотрудники не найдены', ['phone' => $phoneTo]);
            return AppearedResult::NoEmployees;
        }

        $event = new UserEvent(EventType::Call, $personIds, [
            'action' => WebSocketAction::add,
            'callId' => $call->id
        ]);

        broadcast($event);

        return AppearedResult::Ok;
    }

    public function connected()
    {

    }

    public function summary()
    {

    }
}
