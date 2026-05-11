<?php

namespace App\Manager\UseCases;

use App\Core\Jobs\SendMailJob;
use App\Core\Models\Direction;
use App\Core\Models\Employee\Employee;
use App\Core\Models\Employee\EmployeeReportAccess;
use App\Core\Models\Employee\EmployeeRideAccess;
use App\Core\Models\Invite\Invite;
use App\Core\Models\User\User;
use App\Manager\Mails\Invite\SendInviteMail;
use Illuminate\Support\Facades\DB;

abstract class AbstractInviteService
{
    /**
     * @throws \Throwable
     */
    public function cancel(int $inviteId): void
    {
        $invite = Invite::getWaitById($inviteId);
        $invite->deleteOrFail();
    }

    /**
     * @throws \Throwable
     */
    public function confirm(int $inviteId): void
    {
        $invite = Invite::getWaitById($inviteId);

        DB::beginTransaction();

        try {
            $invite->confirm();
            $invite->saveOrFail();

            $directions = Direction::all();

            $employee = Employee::create([
                'legal_id' => $invite->legal_id,
                'phys_id' => $invite->phys_id,
            ]);

            foreach ($directions as $direction) {
                EmployeeReportAccess::create([
                    'employee_id' => $employee->id,
                    'phys_id' => $invite->phys_id,
                    'legal_id' => $invite->legal_id,
                    'direction_id' => $direction->id,
                ]);
            }

            EmployeeRideAccess::create([
                'employee_id' => $employee->id,
                'phys_id' => $invite->phys_id,
                'legal_id' => $invite->legal_id,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     */
    public function complete(int $inviteId): void
    {
        $invite = Invite::getActiveById($inviteId);

        DB::beginTransaction();

        try {
            $invite->complete();
            $invite->saveOrFail();

            $employee = Employee::getByPhysId($invite->phys_id);
            $employee->deleteOrFail();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function sendInviteEmail(User $user): void
    {
        if ($user->isPhys()) {
            $viewLink = url("/manager/{$user->role}/settings/legals");
        } elseif ($user->isLegal()) {
            $viewLink = url("/manager/{$user->role}/settings/persons");
        } else {
            throw new \Exception('Некорректная роль пользователя.');
        }

        $mail = new SendInviteMail($user->email, $viewLink);
        SendMailJob::dispatch($mail);
    }
}
