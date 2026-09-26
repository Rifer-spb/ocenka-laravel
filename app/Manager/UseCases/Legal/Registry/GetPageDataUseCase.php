<?php

namespace App\Manager\UseCases\Legal\Registry;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\User\Legal\Legal;

class GetPageDataUseCase
{
    public function execute(Legal $legal): array
    {
        return [
            'template' => $legal->profile->registry_template,
            'employees' => EmployeeFinder::getRegistryAccessList()
        ];
    }
}
