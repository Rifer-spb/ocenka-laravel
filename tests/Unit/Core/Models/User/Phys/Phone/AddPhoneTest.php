<?php

namespace Tests\Unit\Core\Models\User\Phys\Phone;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\NationalPhone;
use Tests\TestCase;

class AddPhoneTest extends TestCase
{
    public function testSuccess()
    {
        $user = $this->createUser();

        $phone = new NationalPhone($value = '79876543210');
        $user->addPhone($phone);
        $this->assertTrue($user->hasPhone($value));

        $user = Phys::findOrFail($user->id);
        $this->assertTrue($user->hasPhone($value));
    }

    public function testAlreadyExists()
    {
        $user = $this->createUser();

        $phone = new NationalPhone($value = '79876543210');
        $user->addPhone($phone);
        $this->assertTrue($user->hasPhone($value));

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Номер телефона {$value} уже добавлен.");

        $user->addPhone($phone);
    }

    private function createUser(): Phys
    {
        return Phys::createNew(
            new Email('test@test.com'),
            new Password('password'),
        );
    }
}
