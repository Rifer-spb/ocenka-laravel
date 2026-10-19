<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Core\ReadServices\LegalTypeReadService;
use App\Manager\ReadServices\Legal\LegalProfileReadService;
use Inertia\Inertia;
use Inertia\Response;

class AccountPageController extends AbstractController
{
    public function __construct(
        private LegalTypeReadService $typeReadService,
        private LegalProfileReadService $profileReadService
    )
    {
    }

    public function __invoke(): Response
    {
        return Inertia::render('manager/legal/settings/account/index', [
            'types' => $this->typeReadService->getAll(),
            'company' => $this->profileReadService->getCompany($this->getUser())
        ]);
    }
}
