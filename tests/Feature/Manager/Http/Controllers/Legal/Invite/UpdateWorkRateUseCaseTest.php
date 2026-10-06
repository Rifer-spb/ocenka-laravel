<?php

namespace Feature\Manager\Http\Controllers\Legal\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\User\Legal\Legal;
use Tests\TestCase;

class UpdateWorkRateUseCaseTest extends TestCase
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

    public function testRequired()
    {
        $invite = Invite::factory()->withActive()->withEmployee()->create();
        $response = $this->actingAs($invite->legal)->patch($this->getRoute($invite), [
            'value' => ''
        ]);
        $invite->refresh();

        $response->assertSessionHas(['success' => 'Успешно обновлено']);
        $this->assertEquals(0, $invite->phys->employee->work_rate);
    }

    public function testInteger()
    {
        $invite = Invite::factory()->withActive()->withEmployee()->create();
        $response = $this->actingAs($invite->legal)->patch($this->getRoute($invite), [
            'value' => 'value'
        ]);

        $response->assertSessionHasErrors(['value' => 'Значение должно быть числом']);
    }

    public function testMin()
    {
        $invite = Invite::factory()->withActive()->withEmployee()->create();
        $response = $this->actingAs($invite->legal)->patch($this->getRoute($invite), [
            'value' => -5
        ]);

        $response->assertSessionHasErrors(['value' => 'Значение не может быть отрицательным']);
    }

    public function testSuccess()
    {
        $invite = Invite::factory()->withActive()->withEmployee()->create();
        $response = $this->actingAs($invite->legal)->patch($this->getRoute($invite), [
            'value' => $value = 9
        ]);
        $invite->refresh();

        $response->assertSessionHas(['success' => 'Успешно обновлено']);
        $this->assertEquals($value, $invite->phys->employee->work_rate);
    }

    private function getLegal(): Legal
    {
        return Legal::factory()->create();
    }

    private function getRoute(Invite $invite): string
    {
        return route('manager.legal.settings.invites.updateWorkRate', [
            'invite' => $invite->id
        ]);
    }
}
