<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\PageData\Legal\Settings\CallPageData;
use Inertia\Inertia;
use Inertia\Response;

class CallPageController extends AbstractController
{
    public function __construct(
        private CallPageData $pageData
    )
    {
    }

    public function __invoke(): Response
    {
        $pageData = $this->pageData->build($this->getUser());

        return Inertia::render('manager/legal/settings/call/index', [...$pageData]);
    }
}
