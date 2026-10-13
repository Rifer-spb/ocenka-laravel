<?php

namespace Tests\Unit\Core\Entities\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteStatus;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Invite::class, 'confirm')]
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
