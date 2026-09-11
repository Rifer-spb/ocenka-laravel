<?php

namespace Tests\Unit\Core\Models\Invite;

use App\Core\Models\Invite\Invite;
use Tests\TestCase;

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
