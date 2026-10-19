<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Core\ReadServices\CallCommentTemplateReadService;
use App\Manager\ReadServices\Legal\LegalEmployeeReadService;
use App\Manager\ReadServices\Legal\LegalProfileReadService;
use Inertia\Inertia;
use Inertia\Response;

class CallPageController extends AbstractController
{
    public function __construct(
        private LegalEmployeeReadService $employeeReadService,
        private CallCommentTemplateReadService $callCommentTemplateReadService,
        private LegalProfileReadService $profileReadService
    )
    {
    }

    public function __invoke(): Response
    {
        return Inertia::render('manager/legal/settings/call/index', [
            'employees' => $this->employeeReadService->getCallSettings($this->getUser()),
            'templates' => $this->callCommentTemplateReadService->getAllByLegal($this->getUserId()),
            'phones' => $this->profileReadService->getPhones($this->getUser()),
        ]);
    }
}
