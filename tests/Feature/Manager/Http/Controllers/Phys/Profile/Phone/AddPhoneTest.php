<?php

namespace Feature\Manager\Http\Controllers\Phys\Profile\Phone;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\NationalPhone;
use Tests\TestCase;

class AddPhoneTest extends TestCase
{
    public function testRequired()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->post($this->getRoute(), ['phone' => '']);

        $response->assertSessionHasErrors(['phone' => 'Поле обязательно к заполнению']);
    }

    public function testAlreadyExist()
    {
        $user = $this->createUser();
        $user->addPhone(new NationalPhone(79998887766));

        $response = $this->actingAs($user)
            ->post($this->getRoute(), ['phone' => 79998887766]);

        $response->assertSessionHasErrors(['phone' => 'Такой номер уже добавлен']);
    }


    public function testInvalidWithLetters()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->post($this->getRoute(), ['phone' => 'abc12345']);

        $response->assertSessionHasErrors(['phone' => 'Некорректный номер телефона']);
    }

    public function testSuccess()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->post($this->getRoute(), ['phone' => 79998887766]);

        $response->assertSessionHas(['success' => 'Успешно обновлено']);
    }

    private function getRoute(): string
    {
        return route('manager.phys.settings.account.phones.create');
    }

    private function createUser(): Phys
    {
        return Phys::createNew(
            new Email('test@test.com'),
            new Password('password')
        );
    }
}
