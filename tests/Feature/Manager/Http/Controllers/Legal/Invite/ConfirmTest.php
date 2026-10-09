<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Invite;

use App\Core\Entities\Invite\Invite;
use Tests\TestCase;

class ConfirmTest extends TestCase
{
    use CommonTrait;

    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withActive()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($invite->legal)->patch($route);
        $response->assertSessionHas(['error' => 'Заявка должна быть в статусе ожидания.']);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withWait()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($invite->legal)->patch($route);
        $invite->refresh();

        $response->assertSessionHas(['success' => 'Заявка успешно подтверждена']);
        $this->assertTrue($invite->isActive());
    }

    private function getRoute(Invite $invite): string
    {
        return route('manager.legal.invites.confirm', ['invite' => $invite->id]);
    }
}
