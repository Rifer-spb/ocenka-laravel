<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\ReadServices\Legal\LegalEmployeeReadService;
use App\Manager\ReadServices\Legal\LegalProfileReadService;
use Inertia\Inertia;
use Inertia\Response;

class RegistryPageController extends AbstractController
{
    public function __construct(
        private LegalProfileReadService $profileReadService,
        private LegalEmployeeReadService $employeeReadService
    )
    {
    }

    public function __invoke(): Response
    {
        return Inertia::render('manager/legal/settings/registry/index', [
            'template' => $this->profileReadService->getRegistryTemplate($this->getUser()),
            'employees' => $this->employeeReadService->getRegistrySettings($this->getUser()),
        ]);
    }
}
