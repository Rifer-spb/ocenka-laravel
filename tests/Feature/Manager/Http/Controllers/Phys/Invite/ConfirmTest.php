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

        $response = $this->actingAs($phys)->patch($this->getRoute($invite->id));
        $response->assertStatus(404);
    }

    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withActive()->create();

        $response = $this->actingAs($invite->phys)->patch($this->getRoute($invite->id));
        $response->assertSessionHas(['error' => 'Заявка должна быть в статусе ожидания.']);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withWait()->create();
        $response = $this->actingAs($invite->phys)->patch($this->getRoute($invite->id));
        $invite->refresh();

        $response->assertSessionHas(['success' => 'Заявка успешно подтверждена']);
        $this->assertTrue($invite->isActive());
    }

    private function getPhys(): Phys
    {
        return Phys::factory()->create();
    }

    private function getRoute(int $id): string
    {
        return route('manager.phys.invites.confirm', ['invite' => $id]);
    }
}
