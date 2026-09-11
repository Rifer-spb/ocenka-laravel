<?php

namespace Feature\Manager\Http\Controllers\Legal\Invite;

use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use Tests\TestCase;

class CreateUseCaseTest extends TestCase
{
    public function testRequire()
    {
        $user = $this->getLegal();

        $response = $this->actingAs($user)->post($this->getRoute(), [
            'email' => ''
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Поле обязательно к заполнению'
        ]);
    }

    public function testInvalidEmail()
    {
        $user = $this->getLegal();

        $response = $this->actingAs($user)->post($this->getRoute(), [
            'email' => 'invalid-email'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Некорректный e-mail адрес'
        ]);
    }

    public function testNotExists()
    {
        $user = $this->getLegal();

        $response = $this->actingAs($user)->post($this->getRoute(), [
            'email' => 'not-exist@email.ru'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Сотрудник с указанным e-mail не найден'
        ]);
    }

    public function testSuccess()
    {
        $legal = $this->getLegal();
        $phys = Phys::factory()->create();

        $response = $this->actingAs($legal)->post($this->getRoute(), [
            'email' => $phys->email,
        ]);

        $response->assertSessionHas(['success' => 'Заявка успешно отправлена']);

        $this->assertDatabaseHas(Invite::getTableName(), [
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'status' => InviteStatus::WAIT->value
        ]);
    }

    private function getLegal(): Legal
    {
        return Legal::factory()->create();
    }

    private function getRoute(): string
    {
        return route('manager.legal.settings.invites.create');
    }
}
