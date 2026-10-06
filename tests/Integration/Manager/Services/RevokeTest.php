<?php

namespace Integration\Manager\Services;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\Invite\Invite;
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
        $useCase->close($invite);

        $this->assertTrue($invite->isComplete());
        $this->assertDatabaseMissing(Employee::getTableName(), [
            'phys_id' => $invite->phys_id,
            'legal_id' => $invite->legal_id,
        ]);
    }
}
