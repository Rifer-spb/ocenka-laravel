<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Invite;

use App\Core\Entities\Invite\Invite;
use App\Manager\Http\Controllers\Legal\InviteController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(InviteController::class, 'cancel')]
class CancelTest extends TestCase
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

        $response->assertSessionHas(['success' => 'Заявка успешно отменена']);
        $this->assertDatabaseMissing(Invite::getTableName(), ['id' => $invite->id]);
    }

    private function getRoute(Invite $invite): string
    {
        return route('manager.legal.invites.cancel', ['invite' => $invite->id]);
    }
}
