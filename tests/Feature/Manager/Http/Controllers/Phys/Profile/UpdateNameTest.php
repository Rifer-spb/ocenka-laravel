<?php

namespace Feature\Manager\Http\Controllers\Phys\Profile;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\ValueObjects\FirstName;
use App\Core\Models\User\ValueObjects\LastName;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\Models\User\ValueObjects\SecondName;
use App\Core\ValueObjects\Email;
use Tests\TestCase;

class UpdateNameTest extends TestCase
{
    public function testMaxLength()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->patch($this->getRoute(), [
                'firstName' => str_repeat('абв', 101),
                'secondName' => str_repeat('абв', 102),
                'lastName' => str_repeat('абв', 103),
            ]);

        $response->assertSessionHasErrors(['firstName', 'secondName', 'lastName']);
        $response->assertSessionHasErrors([
            'firstName' => 'Поле Имя не должно превышать 100 символов',
            'secondName' => 'Поле Фамилия не должно превышать 100 символов',
            'lastName' => 'Поле Отчество не должно превышать 100 символов',
        ]);
    }

    public function testFilledSuccess()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->patch($this->getRoute(), [
                'firstName' => $firstName = 'Иванов',
                'secondName' => $secondName = 'Алексей',
                'lastName' => $lastName = 'Валентинович',
            ]);

        $response->assertSessionHas('success', 'Успешно обновлено');

        $user = Phys::findOrFail($user->id);
        $this->assertEquals($firstName, $user->profile->first_name);
        $this->assertEquals($secondName, $user->profile->second_name);
        $this->assertEquals($lastName, $user->profile->last_name);
    }

    public function testEmptySuccess()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->patch($this->getRoute(), [
                'firstName' => $firstName = '',
                'secondName' => $secondName = '',
                'lastName' => $lastName = '',
            ]);

        $response->assertSessionHas('success', 'Успешно обновлено');

        $user = Phys::findOrFail($user->id);
        $this->assertEquals($firstName, $user->profile->first_name);
        $this->assertEquals($secondName, $user->profile->second_name);
        $this->assertEquals($lastName, $user->profile->last_name);
    }

    private function getRoute(): string
    {
        return route('manager.phys.settings.account.name.update');
    }

    private function createUser(): Phys
    {
        $user = Phys::createNew(
            new Email('test@mail.ru'),
            new Password('password')
        );

        $user->updateName(
            new FirstName('FirstName'),
            new SecondName('SecondName'),
            new LastName('LastName'),
        );

        return $user;
    }
}
