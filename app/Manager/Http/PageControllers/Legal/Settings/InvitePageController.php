<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Helpers\InviteHelper;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\ReadServices\Legal\Invite\LegalInviteReadService;
use App\Manager\ReadServices\Legal\Invite\LegalInviteSearchService;
use Inertia\Inertia;
use Inertia\Response;

class InvitePageController extends AbstractController
{
    public function __construct(
        private LegalInviteReadService $inviteReadService,
        private LegalInviteSearchService $searchService
    )
    {
    }

    public function __invoke(InviteSearchRequest $request): Response
    {
        return Inertia::render('manager/legal/settings/invites/index', [
            'tabs' => InviteHelper::getTabs(),
            'counts' => $this->inviteReadService->getCounts($this->getUser()),
            'invites' => $this->searchService->search($this->getUser(), $request),
        ]);
    }
}
