<?php

namespace Feature\Manager\Http\Controllers\Phys\Profile\Phone;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\NationalPhone;
use Tests\TestCase;

class DeletePhoneTest extends TestCase
{
    public function testNotExist()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->delete($this->getRoute(999));

        $response->assertStatus(404);
    }

    public function testSuccess()
    {
        $user = $this->createUser();
        $phone = $user->addPhone(new NationalPhone(79998887766));

        $response = $this->actingAs($user)
            ->delete($this->getRoute($phone->id));

        $response->assertSessionHas('success', 'Успешно удалено');

        $user = Phys::findOrFail($user->id);
        $this->assertFalse($user->hasPhone(79998887766));
    }

    private function getRoute(int $id): string
    {
        return route('manager.phys.settings.account.phones.delete', ['phone' => $id]);
    }

    private function createUser(): Phys
    {
        $user = Phys::new(
            new Email('test@test.com'),
            new Password('password')
        );

        return $user;
    }
}
