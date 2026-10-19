<?php

namespace Tests\Feature\Manager\Http\Controllers\Phys\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\User\Phys\Phys;
use App\Manager\Http\Controllers\Phys\InviteController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(InviteController::class,'cancel')]
class CancelTest extends TestCase
{
    use CommonTrait;

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

        $response->assertSessionHas(['success' => 'Заявка успешно отменена']);
        $this->assertDatabaseMissing(Invite::getTableName(), ['id' => $invite->id]);
    }

    private function getPhys(): Phys
    {
        return Phys::factory()->create();
    }

    private function getRoute(Invite $invite): string
    {
        return route('manager.phys.invites.cancel', ['invite' => $invite->id]);
    }
}
