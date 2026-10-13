<?php

namespace Tests\Unit\Core\Entities\Invite;

use App\Core\Entities\Invite\Invite;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Invite::class, 'isWait')]
#[CoversMethod(Invite::class, 'isActive')]
#[CoversMethod(Invite::class, 'isComplete')]
class InviteStatusTest extends TestCase
{
    public function testWait()
    {
        $invite = Invite::factory()->withWait()->create();

        $this->assertTrue($invite->isWait());
    }

    public function testActive()
    {
        $invite = Invite::factory()->withActive()->create();

        $this->assertTrue($invite->isActive());
    }

    public function testComplete()
    {
        $invite = Invite::factory()->withComplete()->create();

        $this->assertTrue($invite->isComplete());
    }
}
