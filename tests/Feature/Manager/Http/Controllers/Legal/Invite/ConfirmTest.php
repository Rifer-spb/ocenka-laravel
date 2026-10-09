<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\User\Legal\Legal;
use Tests\TestCase;

class ConfirmTest extends TestCase
{
    public function testNotFound()
    {
        $legal = $this->getLegal();
        $response = $this->actingAs($legal)->patch($this->getRoute(999));

        $response->assertStatus(404);
    }

    public function testWithAnotherInviteId()
    {
        $legal = $this->getLegal();
        $invite = Invite::factory()->create();

        $response = $this->actingAs($legal)->patch($this->getRoute($invite->id));
        $response->assertStatus(404);
    }

    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withActive()->create();

        $response = $this->actingAs($invite->legal)->patch($this->getRoute($invite->id));
        $response->assertSessionHas(['error' => 'Заявка должна быть в статусе ожидания.']);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withWait()->create();
        $response = $this->actingAs($invite->legal)->patch($this->getRoute($invite->id));
        $invite->refresh();

        $response->assertSessionHas(['success' => 'Заявка успешно подтверждена']);
        $this->assertTrue($invite->isActive());
    }

    private function getLegal(): Legal
    {
        return Legal::factory()->create();
    }

    private function getRoute(int $id): string
    {
        return route('manager.legal.invites.confirm', ['invite' => $id]);
    }
}
