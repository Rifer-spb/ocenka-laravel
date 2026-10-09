<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Invite;

use App\Core\Entities\Invite\Invite;
use Tests\TestCase;

class CloseTest extends TestCase
{
    use CommonTrait;

    public function testInvalidStatus()
    {
        $invite = Invite::factory()->withWait()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($invite->legal)->patch($route);
        $response->assertSessionHas(['error' => 'Заявка должна быть в активном статусе.']);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withActive()->withEmployee()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($invite->legal)->patch($route);
        $invite->refresh();

        $response->assertSessionHas(['success' => 'Заявка успешно завершена']);
        $this->assertTrue($invite->isComplete());
    }

    private function getRoute(Invite $invite): string
    {
        return route('manager.legal.invites.close', ['invite' => $invite->id]);
    }
}
