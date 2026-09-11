<?php

namespace Feature\Manager\Http\Controllers\Legal\Invite;

use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Legal\Legal;
use Tests\TestCase;

class UpdateManagerUseCaseTest extends TestCase
{
    public function testWithAnotherInviteId()
    {
        $legal = $this->getLegal();
        $invite = Invite::factory()->withEmployee()->create();

        $response = $this->actingAs($legal)->patch($this->getRoute($invite));
        $response->assertSessionHas(['error' => 'Отправленная заявка не найдена.']);
    }

    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withWait()->withEmployee()->create();

        $response = $this->actingAs($invite->legal)->patch($this->getRoute($invite));
        $response->assertSessionHas(['error' => 'Отправленная заявка не найдена.']);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withActive()->withEmployee()->create();
        $response = $this->actingAs($invite->legal)->patch($this->getRoute($invite));
        $invite->refresh();

        $response->assertSessionHas(['success' => 'Успешно обновлено']);

        $this->assertTrue($invite->phys->employee->is_manager);
    }

    private function getLegal(): Legal
    {
        return Legal::factory()->create();
    }

    private function getRoute(Invite $invite): string
    {
        return route('manager.legal.settings.invites.updateManager', [
            'invite' => $invite->id
        ]);
    }
}
