<?php

namespace App\Manager\PageData\Phys\Settings;

use App\Core\Helpers\DateHelper;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\Invite\InviteTab;
use App\Core\Models\User\User;
use App\Manager\Helpers\InviteHelper;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\ReadServices\InviteReadService;

class InvitePageData
{
    public function execute(User $user, InviteSearchRequest $request): array
    {
        return [
            'tabs' => InviteHelper::getTabs(),
            'counts' => InviteReadService::getCounts($user),
            'invites' => $this->searchInvites($user, $request)
        ];
    }

    private function searchInvites(User $user, InviteSearchRequest $request): array
    {
        $invites = InviteReadService::querySearch($user, InviteTab::from($request->type))->get()->all();

        return array_map(fn (Invite $m) => $this->getInviteArray($m), $invites);
    }

    private function getInviteArray(Invite $model): array
    {
        $status = InviteStatus::tryFrom($model->status);

        return [
            'id' => $model->id,
            'legal' => [
                'name' => $model->legal->getName(),
            ],
            'status' => [
                'id' => $status->value,
                'name' => $status->getLabel(),
            ],
            'created_at' => DateHelper::toDatetime($model->created_at),
            'completed_at' => DateHelper::toDatetime($model->completed_at),
        ];
    }
}
