<?php

namespace App\Core\Services\Mango;

use App\Core\Entities\Call\Call;
use App\Core\Entities\Call\MangoCallId;
use App\Core\Entities\Employee\PhoneExtension;
use App\Core\Events\WebSocket\EventType;
use App\Core\Events\WebSocket\UserEvent;
use App\Core\Finders\CallFinder;
use App\Core\Finders\EmployeeFinder;
use App\Core\Finders\LegalFinder;
use App\Core\ValueObjects\NationalPhone;
use Carbon\CarbonImmutable;

class MangoService
{
    /**
     * @param MangoCallId $entryId
     * @param NationalPhone $phoneFrom
     * @param NationalPhone $phoneTo
     * @param CarbonImmutable $appearedAt
     * @return void
     * @throws \Throwable
     */
    public function appeared(MangoCallId $entryId, NationalPhone $phoneFrom, NationalPhone $phoneTo, CarbonImmutable $appearedAt): void
    {
        if (CallFinder::hasByMangoId($entryId->getValue())) {
            throw new \DomainException('Звонок уже добавлен.');
        }

        $legal = LegalFinder::getByPhone($phoneTo->getValue());

        $call = Call::createNew(
            $legal,
            $entryId,
            $phoneFrom,
            $phoneTo,
            $appearedAt
        );

        $physIds = EmployeeFinder::getAllPhysIdWithCallAccess($legal);

        $event = new UserEvent(EventType::Call, $physIds, [
            'action' => WebSocketAction::add,
            'callId' => $call->id
        ]);

        broadcast($event);
    }

    /**
     * @param MangoCallId $entryId
     * @param PhoneExtension $extension
     * @param CarbonImmutable $connectedAt
     * @return void
     * @throws \Throwable
     */
    public function connected(MangoCallId $entryId, PhoneExtension $extension, CarbonImmutable $connectedAt): void
    {
        $call = CallFinder::getByMangoId($entryId->getValue());
        $employee = EmployeeFinder::getByPhoneExtension($extension->getValue());

        $call->connectedBy($employee, $connectedAt);
        $call->saveOrFail();

        $physIds = EmployeeFinder::getAllPhysIdWithCallAccess($call->legal);

        unset($physIds[array_search($employee->id, $physIds)]);

        $event = new UserEvent(EventType::Call, $physIds, [
            'action' => WebSocketAction::delete,
            'callId' => $call->id
        ]);

        broadcast($event);

        $event = new UserEvent(EventType::Call, [$employee->id], [
            'action' => WebSocketAction::update,
            'callId' => $call->id
        ]);

        broadcast($event);
    }

    /**
     * @param MangoCallId $entryId
     * @param MangoCallStatus $status
     * @param CarbonImmutable $endedAt
     * @return void
     * @throws \Throwable
     */
    public function summary(MangoCallId $entryId, MangoCallStatus $status, CarbonImmutable $endedAt): void
    {
        $call = CallFinder::getByMangoId($entryId->getValue());

        if ($status->isMissed()) {
            if (! $call->isMissed()) {
                throw new \DomainException('Звонок не в статусе пропущенного.');
            }

            $physIds = EmployeeFinder::getAllPhysIdWithCallAccess($call->legal);

            $event = new UserEvent(EventType::Call, $physIds, [
                'action' => WebSocketAction::delete,
                'callId' => $call->id
            ]);

            broadcast($event);

            return;
        }

        $call->ended($endedAt);
        $call->saveOrFail();

        $event = new UserEvent(EventType::Call, [$call->phys_id], [
            'action' => WebSocketAction::update,
            'callId' => $call->id
        ]);

        broadcast($event);
    }
}
