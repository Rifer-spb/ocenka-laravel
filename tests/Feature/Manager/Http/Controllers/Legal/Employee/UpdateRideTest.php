<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Employee;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\User\Legal\Legal;
use Tests\TestCase;

class UpdateRideTest extends TestCase
{
    public function testWithAnotherInviteId()
    {
        $legal = $this->getLegal();
        $invite = Invite::factory()->withEmployee()->create();

        $response = $this->actingAs($legal)->patch($this->getRoute($invite));
        $response->assertStatus(404);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withActive()->withEmployee()->create();
        $response = $this->actingAs($invite->legal)->patch($this->getRoute($invite));
        $invite->refresh();

        $response->assertSessionHas(['success' => 'Успешно обновлено']);

        $this->assertTrue($invite->phys->employee->can_ride);
    }

    private function getLegal(): Legal
    {
        return Legal::factory()->create();
    }

    private function getRoute(Invite $invite): string
    {
        return route('manager.legal.employees.updateRide', [
            'employee' => $invite->employee->id
        ]);
    }
}
