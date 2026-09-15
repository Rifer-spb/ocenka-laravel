<?php

namespace App\Manager\UseCases\Phys\Invite;

use App\Core\Helpers\DateHelper;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\Invite\InviteTab;
use App\Core\Models\User\User;
use App\Manager\Finders\InviteFinder;
use App\Manager\Helpers\InviteHelper;
use App\Manager\Http\Requests\InviteSearchRequest;

class GetPageDataUseCase
{
    public function execute(User $user, InviteSearchRequest $request): array
    {
        return [
            'tabs' => InviteHelper::getTabs(),
            'counts' => InviteFinder::getCounts($user),
            'invites' => $this->searchInvites($user, $request)
        ];
    }

    private function searchInvites(User $user, InviteSearchRequest $request): array
    {
        $allRequests = Invite::where('phys_id', $user->id);

        match ($request->type) {
            InviteTab::INBOX->value => $allRequests->where([
                'for' => InviteForWho::PHYS,
                'status' => InviteStatus::WAIT->value,
            ]),
            InviteTab::OUTBOX->value => $allRequests->where([
                'for' => InviteForWho::LEGAL,
                'status' => InviteStatus::WAIT->value,
            ]),
            InviteTab::ACTIVE->value => $allRequests->where([
                'status' => InviteStatus::ACTIVE->value,
            ]),
            InviteTab::COMPLETE->value => $allRequests->where([
                'status' => InviteStatus::COMPLETE->value,
            ]),
        };

        $invites = $allRequests->get()->all();

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
