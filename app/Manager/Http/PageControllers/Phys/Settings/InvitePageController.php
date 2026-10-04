<?php

namespace App\Manager\Http\PageControllers\Phys\Settings;

use App\Core\Helpers\DateHelper;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\Invite\InviteTab;
use App\Core\Models\User\User;
use App\Manager\Helpers\InviteHelper;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\ReadServices\InviteReadService;
use Inertia\Inertia;
use Inertia\Response;

class InvitePageController extends AbstractController
{
    public function __invoke(InviteSearchRequest $request): Response
    {
        return Inertia::render('manager/phys/settings/invites/index', $this->getData($request));
    }

    public function getData(InviteSearchRequest $request): array
    {
        $user = $this->getUser();

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
