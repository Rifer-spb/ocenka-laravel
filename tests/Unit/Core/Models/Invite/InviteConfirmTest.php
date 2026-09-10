<?php

namespace Tests\Unit\Core\Models\Invite;

use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteStatus;
use Tests\TestCase;

class InviteConfirmTest extends TestCase
{
    public function testInvalid()
    {
        $invite = Invite::factory()
            ->state(['status' => InviteStatus::ACTIVE->value])
            ->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Заявка должна быть в статусе ожидания.');

        $invite->confirm();
    }

    public function testSuccess()
    {
        $invite = Invite::factory()
            ->state(['status' => InviteStatus::WAIT->value])
            ->create();

        $invite->confirm();

        $this->assertTrue($invite->isActive());
    }
}
