<?php

namespace App\Manager\ReadServices\Phys;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteStatus;
use App\Core\Entities\Invite\InviteTab;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Helpers\DateHelper;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\Queries\Phys\PhysInviteQuery;

class PhysInviteSearchService
{
    public function search(Phys $phys, InviteSearchRequest $request): array
    {
        $invites = PhysInviteQuery::searchQuery($phys, InviteTab::from($request->type));

        return array_map(function (Invite $model) {
            return [
                'id' => $model->id,
                'legal' => $this->getLegal($model),
                'status' => $this->getStatus($model),
                'created_at' => DateHelper::toDatetime($model->created_at),
                'completed_at' => DateHelper::toDatetime($model->completed_at),
            ];
        }, $invites->get()->all());
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
