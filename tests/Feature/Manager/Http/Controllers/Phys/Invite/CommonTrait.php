<?php

namespace Tests\Feature\Manager\Http\Controllers\Phys\Invite;

use App\Core\Entities\Invite\Invite;

trait CommonTrait
{
    public function testWithAnotherInviteId()
    {
        $phys = $this->getPhys();
        $invite = Invite::factory()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($phys)->patch($route);
        $response->assertStatus(404);
    }
}
