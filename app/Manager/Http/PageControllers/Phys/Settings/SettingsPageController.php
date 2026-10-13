<?php

namespace App\Manager\Http\PageControllers\Phys\Settings;

use App\Core\Http\Controllers\AbstractController;
use Inertia\Inertia;
use Inertia\Response;

class SettingsPageController extends AbstractController
{
    public function __invoke(): Response
    {
        return Inertia::render('manager/phys/settings/index');
    }
}
