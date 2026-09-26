<?php

namespace App\Manager\PageData\Legal\Settings;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\User\Legal\Legal;

class RegistryPageData
{
    public function execute(Legal $legal): array
    {
        return [
            'template' => $legal->profile->registry_template,
            'employees' => EmployeeFinder::getRegistryAccessList()
        ];
    }
}
