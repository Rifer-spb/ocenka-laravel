<?php

namespace App\Manager\Http\PageControllers\Phys\Settings;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\ReadServices\Phys\PhysProfileReadService;
use Inertia\Inertia;
use Inertia\Response;

class AccountPageController extends AbstractController
{
    public function __construct(
        private PhysProfileReadService $profileReadService
    )
    {
    }

    public function __invoke(): Response
    {
        return Inertia::render('manager/phys/settings/account/index', [
            'profile' => $this->profileReadService->getProfile($this->getUser()),
            'phones' => $this->profileReadService->getPhones($this->getUser()),
        ]);
    }


}
