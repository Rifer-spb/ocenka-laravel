<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\PageData\Legal\Settings\AccountPageData;
use Inertia\Inertia;
use Inertia\Response;

class AccountPageController extends AbstractController
{
    public function __construct(
        private AccountPageData $pageData
    )
    {
    }

    public function __invoke(): Response
    {
        $pageData = $this->pageData->build($this->getUser());

        return Inertia::render('manager/legal/settings/account/index', [...$pageData]);
    }
}
