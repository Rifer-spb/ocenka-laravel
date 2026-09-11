<?php

namespace Feature\Manager\Http\Controllers\Phys\Profile;

use App\Core\Models\User\Phys\Phys;
use Tests\TestCase;

class UpdateHolidayTest extends TestCase
{
    public function testRequiredEmpty()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->patch($this->getRoute(), [
            'holidayFrom' => '',
            'holidayTo' => '',
        ]);

        $response->assertSessionHasErrors([
            'holidayFrom' => 'Поле обязательно для заполнения',
            'holidayTo' => 'Поле обязательно для заполнения',
        ]);
    }

    public function testToMustBeAfterHolidayFrom()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->patch($this->getRoute(), [
            'holidayFrom' => '2026-08-10',
            'holidayTo' => '2026-08-01',
        ]);

        $response->assertSessionHasErrors([
            'holidayTo' => 'Дата должна быть больше чем дата От',
        ]);
    }

    public function testSuccess()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->patch($this->getRoute(), [
            'holidayFrom' => '2026-08-01',
            'holidayTo' => '2026-08-10',
        ]);

        $response->assertSessionHas(['success' => 'Успешно обновлено']);
    }

    private function createUser(): Phys
    {
        return Phys::factory()->withProfile()->create();
    }

    private function getRoute(): string
    {
        return route('manager.phys.settings.account.holiday.update');
    }
}
