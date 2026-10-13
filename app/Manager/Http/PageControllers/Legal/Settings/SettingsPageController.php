<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Http\Controllers\AbstractController;
use Inertia\Inertia;
use Inertia\Response;

class SettingsPageController extends AbstractController
{
    public function __invoke(): Response
    {
        return Inertia::render('manager/legal/settings/index');
    }
}
