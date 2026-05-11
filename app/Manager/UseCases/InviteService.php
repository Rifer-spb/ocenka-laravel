<?php

namespace App\Manager\UseCases;

use App\Core\Jobs\SendMailJob;
use App\Core\Models\Direction;
use App\Core\Models\Employee\EmployeeReportAccess;
use App\Core\Models\Employee\EmployeeRideAccess;
use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Manager\Mails\Invite\SendInviteMail;
use App\Manager\Modules\Phys\Http\Requests\Legal\Invite\CreateRequest;

class InviteService
{
    /**
     * @throws \Throwable
     */
    public function create(int $userId, CreateRequest $request): void
    {
        $phys = Phys::findOrFail($userId);
        $legal = Legal::getByUsername($request->email);

        $hasWaitInvite = Invite::hasWait($phys, $legal);

        if ($hasWaitInvite) {
            throw new \DomainException('Заявка с указанным юр.лицом уже существует.');
        }

        $hasActive = Invite::hasActive($phys, $legal);

        if ($hasActive) {
            throw new \DomainException('Связь с указанным юр. лицом уже установлена.');
        }

        $invite = Invite::createByPhys($phys, $legal);
        $this->sendInviteEmail($invite);
    }

    public function reSend(int $inviteId): void
    {
        $invite = Invite::getWaitById($inviteId);
        $this->sendInviteEmail($invite);
    }

    /**
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     */
    public function cancel(int $inviteId): void
    {
        $invite = Invite::getWaitById($inviteId);
        $invite->deleteOrFail();
    }

    /**
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     */
    public function confirm(int $inviteId): void
    {
        $invite = Invite::getWaitById($inviteId);
        $invite->confirm();
        $invite->saveOrFail();

        $directions = Direction::all();

        foreach ($directions as $direction) {
            EmployeeReportAccess::create([
                'phys_id' => $invite->phys_id,
                'legal_id' => $invite->legal_id,
                'direction_id' => $direction->id,
            ]);

            EmployeeRideAccess::create([
                'phys_id' => $invite->phys_id,
                'legal_id' => $invite->legal_id,
            ]);
        }
    }

    private function sendInviteEmail(Invite $invite): void
    {
        $mail = new SendInviteMail(
            $invite->legal->role,
            $invite->legal->email
        );

        SendMailJob::dispatch($mail);
    }
}
