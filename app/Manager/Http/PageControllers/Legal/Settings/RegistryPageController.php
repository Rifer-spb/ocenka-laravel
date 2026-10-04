<?php

namespace App\Manager\Http\PageControllers\Legal\Settings;

use App\Core\Finder\EmployeeFinder;
use App\Core\Http\Controllers\AbstractController;
use Inertia\Inertia;
use Inertia\Response;

class RegistryPageController extends AbstractController
{
    public function __invoke(): Response
    {
        return Inertia::render('manager/legal/settings/registry/index', [
            'template' => $this->getUser()->profile->registry_template,
            'employees' => EmployeeFinder::getRegistryAccessList()
        ]);
    }
}
