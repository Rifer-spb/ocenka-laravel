<?php

namespace Feature\Manager\Http\Controllers\Phys\Invite;

use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Phys\Phys;
use Tests\TestCase;

class ConfirmUseCaseTest extends TestCase
{
    public function testWithAnotherInviteId()
    {
        $phys = $this->getPhys();
        $invite = Invite::factory()->create();

        $response = $this->actingAs($phys)->patch($this->getRoute($invite->id));
        $response->assertSessionHas(['error' => 'Отправленная заявка не найдена.']);
    }

    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withActive()->create();

        $response = $this->actingAs($invite->phys)->patch($this->getRoute($invite->id));
        $response->assertSessionHas(['error' => 'Отправленная заявка не найдена.']);
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
        return route('manager.phys.settings.invites.confirm', ['invite' => $id]);
    }
}
