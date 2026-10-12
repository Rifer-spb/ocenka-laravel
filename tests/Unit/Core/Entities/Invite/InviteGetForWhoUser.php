<?php

namespace Tests\Unit\Core\Entities\Invite;

use App\Core\Entities\Invite\Invite;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Invite::class, 'getForWhoUser')]
class InviteGetForWhoUser extends TestCase
{
    public function testForPhys()
    {
        $invite = Invite::factory()->withForPhys()->create();
        $user = $invite->getForWhoUser();

        $this->assertTrue($user->isPhys());
    }

    public function testForLegal()
    {
        $invite = Invite::factory()->withForLegal()->create();
        $user = $invite->getForWhoUser();

        $this->assertTrue($user->isLegal());
    }
}
