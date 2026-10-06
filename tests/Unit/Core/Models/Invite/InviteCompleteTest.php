<?php

namespace Tests\Unit\Core\Models\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteStatus;
use Tests\TestCase;

class InviteCompleteTest extends TestCase
{
    public function testInvalid()
    {
        $invite = Invite::factory()
            ->state(['status' => InviteStatus::WAIT->value])
            ->create();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Заявка должна быть в активном статусе.');

        $invite->complete();
    }

    public function testSuccess()
    {
        $invite = Invite::factory()
            ->state(['status' => InviteStatus::ACTIVE->value])
            ->create();

        $invite->complete();

        $this->assertTrue($invite->isComplete());
        $this->assertNotEmpty($invite->completed_at);
    }
}
