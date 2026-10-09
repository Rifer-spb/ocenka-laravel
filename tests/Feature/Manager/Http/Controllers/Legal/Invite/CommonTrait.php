<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\User\Legal\Legal;

trait CommonTrait
{
    public function testWithAnotherInviteId()
    {
        $legal = Legal::factory()->create();
        $invite = Invite::factory()->withWait()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($legal)->patch($route);
        $response->assertStatus(404);
    }
}
