<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Core\ReadServices\CallCommentTemplateReadService;
use App\Core\ReadServices\EmployeeReadService;
use App\Manager\ReadServices\Legal\LegalProfileReadService;
use Inertia\Inertia;
use Inertia\Response;

class CallPageController extends AbstractController
{
    public function __construct(
        private EmployeeReadService $employeeReadService,
        private CallCommentTemplateReadService $callCommentTemplateReadService,
        private LegalProfileReadService $profileReadService
    )
    {
    }

    public function __invoke(): Response
    {
        $user = $this->getUser();
        $userId = $user->id;

        return Inertia::render('manager/legal/settings/call/index', [
            'employees' => $this->employeeReadService->getAllCallAccess($userId),
            'templates' => $this->callCommentTemplateReadService->getAllByLegal($userId),
            'phones' => $this->profileReadService->getAllPhones($user)
        ]);
    }
}
