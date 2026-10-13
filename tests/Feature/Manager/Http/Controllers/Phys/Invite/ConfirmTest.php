<?php

namespace Tests\Feature\Manager\Http\Controllers\Phys\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\User\Phys\Phys;
use Tests\TestCase;

class ConfirmTest extends TestCase
{
    public function testWithAnotherInviteId()
    {
        $phys = $this->getPhys();
        $invite = Invite::factory()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($phys)->patch($route);
        $response->assertStatus(404);
    }

    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withActive()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($invite->phys)->patch($route);
        $response->assertSessionHas(['error' => 'Заявка должна быть в статусе ожидания.']);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withWait()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($invite->phys)->patch($route);
        $invite->refresh();

        $response->assertSessionHas(['success' => 'Заявка успешно подтверждена']);
        $this->assertTrue($invite->isActive());
    }

    private function getPhys(): Phys
    {
        return Phys::factory()->create();
    }

    private function getRoute(Invite $invite): string
    {
        return route('manager.phys.invites.confirm', ['invite' => $invite->id]);
    }
}
