<?php

namespace App\Manager\PageData\Legal\Settings;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\User\Legal\Legal;

class RegistryPageData
{
    public function build(Legal $legal): array
    {
        return [
            'template' => $legal->profile->registry_template,
            'employees' => $this->getAllRegistryAccess($legal)
        ];
    }

    private function getAllRegistryAccess(Legal $legal): array
    {
        $callback = fn (Employee $e) => [
            'id' => $e->id,
            'name' => $e->phys->getName(),
            'value' => $e->can_registry
        ];

        return Employee
            ::select(['id','phys_id','can_registry'])
            ->with(['phys:id,username','phys.profile:id,full_name'])
            ->where('legal_id', $legal->id)
            ->orderBy('id')
            ->get()
            ->map($callback)
            ->all();
    }
}
