<?php

namespace App\Manager\PageData\Legal\Settings;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Legal\LegalPhone;
use App\Core\ReadServices\CallCommentTemplateReadService;

class CallPageData
{
    public function __construct(
        private CallCommentTemplateReadService $callCommentTemplateReadService,
    )
    {
    }

    public function build(Legal $legal): array
    {
        return [
            'employees' => $this->getEmployees($legal->id),
            'templates' => $this->callCommentTemplateReadService->getAllByLegal($legal->id),
            'phones' => $this->getPhones($legal),
        ];
    }

    private function getEmployees(int $legalId): array
    {
        return Employee::
            with([
                'phys:id,username',
                'phys.profile:id,full_name',
            ])
            ->select('id', 'phys_id', 'can_call', 'phone_extension')
            ->where('legal_id', $legalId)
            ->orderBy('id')
            ->get()
            ->map(fn (Employee $e) => [
                'id' => $e->id,
                'name' => $e->phys->getName(),
                'value' => $e->can_call,
                'phoneExtension' => $e->phone_extension
            ])
            ->all();
    }

    private function getPhones(Legal $legal): array
    {
        $callback = fn (LegalPhone $p) => [
            'id' => $p->id,
            'phone' => $p->phone,
        ];

        return $legal->phones->map($callback)->all();
    }
}
