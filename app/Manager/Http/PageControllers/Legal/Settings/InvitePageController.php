<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Helpers\InviteHelper;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\ReadServices\Legal\LegalInviteReadService;
use App\Manager\ReadServices\Legal\LegalInviteSearchService;
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
        $legal = $this->getUser();

        return Inertia::render('manager/legal/settings/invites/index', [
            'tabs' => InviteHelper::getTabs(),
            'counts' => $this->inviteReadService->getCounts($legal),
            'invites' => $this->searchService->search($legal, $request),
        ]);
    }
}
