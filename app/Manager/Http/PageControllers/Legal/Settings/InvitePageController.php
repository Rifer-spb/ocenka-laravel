<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\PageData\Legal\Settings\Invite\InvitePageData;
use Inertia\Inertia;
use Inertia\Response;

class InvitePageController extends AbstractController
{
    public function __construct(
        private InvitePageData $pageData
    )
    {
    }

    public function __invoke(InviteSearchRequest $request): Response
    {
        $pageData = $this->pageData->build($this->getUser(), $request);

        return Inertia::render('manager/legal/settings/invites/index', [...$pageData]);
    }
}
