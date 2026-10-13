<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Profile\Phone;

use App\Core\Entities\User\Legal\Legal;
use App\Core\ValueObjects\NationalPhone;
use App\Manager\Http\Controllers\Legal\ProfileController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(ProfileController::class,'addPhone')]
class AddPhoneTest extends TestCase
{
    public function testRequired()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->post($this->getRoute(), ['phone' => '']);

        $response->assertSessionHasErrors(['phone' => 'Поле обязательно к заполнению']);
    }

    /**
     * @throws \Throwable
     */
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
        return route('manager.legal.profile.phones.create');
    }

    private function createUser(): Legal
    {
        return Legal::factory()->create();
    }
}
