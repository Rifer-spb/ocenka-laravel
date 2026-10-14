<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Core\ReadServices\EmployeeReadService;
use App\Manager\ReadServices\Legal\LegalProfileReadService;
use Inertia\Inertia;
use Inertia\Response;

class RegistryPageController extends AbstractController
{
    public function __construct(
        private LegalProfileReadService $profileReadService,
        private EmployeeReadService $employeeReadService
    )
    {
    }

    public function __invoke(): Response
    {
        return Inertia::render('manager/legal/settings/registry/index', [
            'template' => $this->profileReadService->getRegistryTemplate($this->getUser()),
            'employees' => $this->employeeReadService->getAllRegistryAccess($this->getUserId())
        ]);
    }
}
