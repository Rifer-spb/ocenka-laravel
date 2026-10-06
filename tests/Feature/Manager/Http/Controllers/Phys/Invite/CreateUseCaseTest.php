<?php

namespace Feature\Manager\Http\Controllers\Phys\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteStatus;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use Tests\TestCase;

class CreateUseCaseTest extends TestCase
{
    public function testRequire()
    {
        $user = $this->getPhys();

        $response = $this->actingAs($user)->post($this->getRoute(), [
            'email' => ''
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Поле обязательно к заполнению'
        ]);
    }

    public function testInvalidEmail()
    {
        $user = $this->getPhys();

        $response = $this->actingAs($user)->post($this->getRoute(), [
            'email' => 'invalid-email'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Некорректный e-mail адрес'
        ]);
    }

    public function testNotExists()
    {
        $user = $this->getPhys();

        $response = $this->actingAs($user)->post($this->getRoute(), [
            'email' => 'not-exist@email.ru'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Юр.лицо с указанным e-mail не найден'
        ]);
    }

    public function testSuccess()
    {
        $phys = $this->getPhys();
        $legal = Legal::factory()->create();

        $response = $this->actingAs($phys)->post($this->getRoute(), [
            'email' => $legal->email,
        ]);

        $response->assertSessionHas(['success' => 'Заявка успешно отправлена']);

        $this->assertDatabaseHas(Invite::getTableName(), [
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'status' => InviteStatus::WAIT->value
        ]);
    }

    private function getPhys(): Phys
    {
        return Phys::factory()->create();
    }

    private function getRoute(): string
    {
        return route('manager.phys.settings.invites.create');
    }
}
