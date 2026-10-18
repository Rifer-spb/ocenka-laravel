<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\PageData\Legal\Settings\RegistryPageData;
use Inertia\Inertia;
use Inertia\Response;

class RegistryPageController extends AbstractController
{
    public function __construct(
        private RegistryPageData $pageData
    )
    {
    }

    public function __invoke(): Response
    {
        $pageData = $this->pageData->build($this->getUser());

        return Inertia::render('manager/legal/settings/registry/index', [...$pageData]);
    }
}
