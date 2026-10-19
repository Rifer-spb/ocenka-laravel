<?php

namespace App\Manager\ReadServices\Phys\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\Invite\InviteStatus;
use App\Core\Entities\Invite\InviteTab;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Helpers\DateHelper;
use App\Manager\Helpers\InviteHelper;
use App\Manager\Http\Requests\InviteSearchRequest;

class PhysInviteSearchService
{
    public function search(Phys $phys, InviteSearchRequest $request): array
    {
        $tab = InviteTab::from($request->type);
        $tabStatus = InviteHelper::getStatusByTab($tab);

        $query = Invite::where('phys_id', $phys->id)
            ->with(['legal.profile'])
            ->where('status', $tabStatus->value);

        if ($tab->isInbox()) {
            $query->where('for', InviteForWho::PHYS);
        } elseif ($tab->isOutbox()) {
            $query->where('for', InviteForWho::LEGAL);
        };

        return $query->get()->map($this->getInvite(...))->all();
    }

    private function getInvite(Invite $model): array
    {
        return [
            'id' => $model->id,
            'legal' => $this->getLegal($model),
            'status' => $this->getStatus($model),
            'created_at' => DateHelper::toDatetime($model->created_at),
            'completed_at' => DateHelper::toDatetime($model->completed_at),
        ];
    }

    private function getLegal(Invite $model): array
    {
        return [
            'name' => $model->legal->getName(),
        ];
    }

    private function getStatus(Invite $model): array
    {
        $status = InviteStatus::tryFrom($model->status);

        return [
            'id' => $status->value,
            'name' => $status->getLabel(),
        ];
    }
}
