<?php

namespace Tests\Unit\Core\Models\Invite;

use App\Core\Entities\Invite\Invite;
use Tests\TestCase;

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
