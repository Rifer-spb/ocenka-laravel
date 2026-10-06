<?php

namespace App\Manager\Http\PageControllers\Phys\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Helpers\InviteHelper;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\ReadServices\Phys\PhysInviteReadService;
use App\Manager\ReadServices\Phys\PhysInviteSearchService;
use Inertia\Inertia;
use Inertia\Response;

class InvitePageController extends AbstractController
{
    public function __construct(
        private PhysInviteReadService $inviteReadService,
        private PhysInviteSearchService $searchService,
    )
    {
    }

    public function __invoke(InviteSearchRequest $request): Response
    {
        return Inertia::render('manager/phys/settings/invites/index', $this->getData($request));
    }

    public function getData(InviteSearchRequest $request): array
    {
        $user = $this->getUser();

        return [
            'tabs' => InviteHelper::getTabs(),
            'counts' => $this->inviteReadService->getCounts($user),
            'invites' => $this->searchService->search($user, $request),
        ];
    }
}
