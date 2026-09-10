<?php

namespace Integration\Manager\Services;

use App\Core\Models\Employee\Employee;
use App\Core\Models\Invite\Invite;
use App\Manager\Services\InviteService;
use Tests\TestCase;

class ConfirmTest extends TestCase
{
    public function testSuccess()
    {
        $invite = Invite::factory()->withWait()->create();
        $useCase = app(InviteService::class);

        $useCase->confirm($invite);

        $this->assertTrue($invite->isActive());
        $this->assertDatabaseHas(Employee::getTableName(), [
            'phys_id' => $invite->phys_id,
            'legal_id' => $invite->legal_id,
        ]);
    }
}
