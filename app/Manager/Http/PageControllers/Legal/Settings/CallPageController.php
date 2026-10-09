<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Core\ReadServices\EmployeeReadService;
use Inertia\Inertia;
use Inertia\Response;

class CallPageController extends AbstractController
{
    public function __construct(
        private EmployeeReadService $employeeReadService
    )
    {
    }

    public function __invoke(): Response
    {
        return Inertia::render('manager/legal/settings/call/index', [
            'employees' => $this->employeeReadService->getAllCallAccess()
        ]);
    }
}
