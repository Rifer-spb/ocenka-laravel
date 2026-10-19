<?php

namespace App\Manager\ReadServices\Legal;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\User\Legal\Legal;

class LegalEmployeeReadService
{
    public function getCallSettings(Legal $legal): array
    {
        return Employee::
            with([
                'phys:id,username',
                'phys.profile:id,full_name',
            ])
            ->select('id', 'phys_id', 'can_call', 'phone_extension')
            ->where('legal_id', $legal->id)
            ->orderBy('id')
            ->get()
            ->map(fn (Employee $e) => [
                'id' => $e->id,
                'name' => $e->phys->getName(),
                'canCall' => $e->can_call,
                'phoneExtension' => $e->phone_extension
            ])
            ->all();
    }

    public function getRegistrySettings(Legal $legal): array
    {
        $callback = fn (Employee $e) => [
            'id' => $e->id,
            'name' => $e->phys->getName(),
            'canRegistry' => $e->can_registry
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
