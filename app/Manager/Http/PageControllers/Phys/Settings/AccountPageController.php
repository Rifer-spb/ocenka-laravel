<?php

namespace App\Manager\Http\PageControllers\Phys\Settings;

use App\Core\Http\Controllers\AbstractController;
use Inertia\Inertia;
use Inertia\Response;

class AccountPageController extends AbstractController
{
    public function __invoke(): Response
    {
        $phys = $this->getUser();

        return Inertia::render('manager/phys/settings/account/index', [
            'profile' => $phys->profile,
            'phones' => $phys->phones,
        ]);
    }


}
