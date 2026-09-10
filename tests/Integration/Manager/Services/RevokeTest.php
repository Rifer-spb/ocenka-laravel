<?php

namespace Integration\Manager\Services;

use App\Core\Models\Employee\Employee;
use App\Core\Models\Invite\Invite;
use App\Manager\Services\InviteService;
use Tests\TestCase;

class RevokeTest extends TestCase
{
    public function testSuccess()
    {
        $invite = Invite::factory()
            ->withActive()
            ->withEmployee()
            ->create();

        $useCase = app(InviteService::class);
        $useCase->revoke($invite);

        $this->assertTrue($invite->isComplete());
        $this->assertDatabaseMissing(Employee::getTableName(), [
            'phys_id' => $invite->phys_id,
            'legal_id' => $invite->legal_id,
        ]);
    }
}
